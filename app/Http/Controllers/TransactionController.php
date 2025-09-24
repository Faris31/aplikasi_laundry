<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TransOrder;
use Illuminate\Http\Request;
use App\Models\TypeOfService;
use Illuminate\Support\Carbon;
use App\Models\TransOrderDetail;
use App\Models\TransLaundryPickup;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman index transaksi.
     */
    public function index()
    {
        $title = 'Daftar Transaksi';
        $transOrders = TransOrder::with(['customer', 'details.service'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.transaksi.index', compact('title', 'transOrders'));
    }

    /**
     * Menampilkan form tambah transaksi baru.
     */
    public function create()
    {
        // Prefix kode transaksi
        $code = 'TRS';
        $today = now()->format('Ymd');
        $prefix = $code . '-' . $today;

        // Cari transaksi terakhir hari ini
        $lastTransaction = TransOrder::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTransaction) {
            // Ambil nomor urut terakhir dari order_code
            $lastNumber = (int) substr($lastTransaction->order_code, -3);
            $newNumber = str_pad($lastNumber + 1, 3, "0", STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        $transNumber = $prefix . $newNumber;

        $title = 'Buat Transaksi Baru';
        $customers = Customer::all();
        $services = TypeOfService::all();

        return view('admin.transaksi.form_transaksi', compact(
            'transNumber',
            'title',
            'customers',
            'services'
        ));
    }

    /**
     * Menyimpan data transaksi baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data
         $validated = $request->validate([
            'order_code' => 'required|string',
            'id_customer' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'order_end_date' => 'required|date|after_or_equal:order_date',
            'services' => 'required|array|min:1',
            'services.*.id_service' => 'required|exists:type_of_services,id',
            'services.*.qty' => 'required|numeric|min:0.1',
            'services.*.notes' => 'nullable|string',
        ]);

        try {
            $order = DB::transaction(function () use ($validated) {
                $serviceIds = collect($validated['services'])->pluck('id_service');
                $services = TypeOfService::whereIn('id', $serviceIds)->get()->keyBy('id');


                $total = collect($validated['services'])->reduce(function ($carry, $item) use ($services) {
                    return $carry + ($services[$item['id_service']]->price * $item['qty']);
                }, 0);

                $order = TransOrder::create([
                    'id_customer' => $validated['id_customer'],
                    'order_code' => $validated['order_code'],
                    'order_date' => $validated['order_date'],
                    'order_end_date' => $validated['order_end_date'],
                    'order_status' => 0,
                    'total' => $total,
                    'order_pay' => 0,
                    'order_change' => 0,
                ]);

                $orderDetails = collect($validated['services'])->map(function ($item) use ($services, $order) {
                    $price = $services[$item['id_service']]->price;
                    return [
                        'id_order' => $order->id,
                        'id_service' => $item['id_service'],
                        'qty' => $item['qty'],
                        'subtotal' => $price * $item['qty'],
                        'notes' => $item['notes'],
                    ];
                });

                TransOrderDetail::insert($orderDetails->toArray());

                return $order;
            });
            return redirect()
                    ->route('transaksi.print', $order->id)
                    ->with('success_message', 'Order berhasil dibuat!!');
        } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->with('error_message', 'Terjadi kesalahan saat membuat order: ' . $e->getMessage());
        }
    }

    public function print(string $id)
    {
        // return $order;
        try {

            $order = TransOrder::with(['customer', 'details.service'])->find($id);

            return view('admin.transaksi.print', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('transaksi.index')->with('error_message', 'Gagal memuat struk: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show($id)
    {
    $order = TransOrder::with(['customer', 'details.service'])
        ->findOrFail($id);

    $title = 'Detail Transaksi: ' . $order->order_code;

    return view('admin.transaksi.show', compact('order', 'title'));
    }

    /**
     * Edit transaksi (jika diperlukan).
     */
    public function edit(string $id)
    {
        $order = TransOrder::with(['customer', 'details.service'])->findOrFail($id);
        $customers = Customer::all();
        $services = TypeOfService::all();

        return view('admin.transaksi.edit', compact('order', 'customers', 'services'));
    }

    public function complete(Request $request, string $id)
    {
        $request->validate([
            'order_pay' => 'required|numeric|min:0',
            'notes' => 'nullable|string', // optional untuk pickup
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $order = TransOrder::findOrFail($id);

                if ($request->order_pay < $order->total) {
                    throw new \Exception('Pembayaran tidak mencukupi!');
                }

                $orderChange = $request->order_pay - $order->total;

                // Update status order
                $order->update([
                    'order_pay' => $request->order_pay,
                    'order_change' => $orderChange,
                    'order_status' => 1, // selesai
                ]);

                TransLaundryPickup::create([
                    'id_order' => $order->id,
                    'id_customer' => $order->id_customer,
                    'pickup_date' => Carbon::now(),
                    'notes' => $request->notes ?? null,
                ]);
            });

            return redirect()->route('transaksi.index')
                ->with('success_message', 'Order berhasil diselesaikan, pembayaran dicatat, dan pickup tersimpan.');
        } catch (\Exception $e) {
            return redirect()->route('transaksi.show', $id)
                ->with('error_message', 'Gagal menyelesaikan order: ' . $e->getMessage());
        }
    }

    public function showTransaction()
    {
        $customers = Customer::get();
        $services = TypeOfService::get();
        return view('admin.transaksi.form_transaksi', compact('customers', 'services'));
    }
    public function OrderStore(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'customer.id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'total' => 'required|numeric',
            'order_date' => 'required|date',
            'order_status' => 'required|bool'
        ]);

        DB::beginTransaction();
        try {
            // Simpan Order
            $order = TransOrder::create([
                'order_code' => $request->id,
                'id_customer' => $request->customer['id'],
                'order_date' => $request->order_date,
                'order_end_date' => Carbon::now()->toDateString(),
                'order_pay' => 0,
                'order_change' => 0,
                'order_status' => $request->order_status,
                'total' => $request->total
            ]);

            // Simpan Detail Orders
            foreach ($request->items as $item) {
                TransOrderDetail::create([
                    'id_order' => $order->id,
                    'id_service' => $item['id_service'],
                    'qty' => $item['weight'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'notes' => $item['notes'] ?? null
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => $order->load('details.service', 'customer')
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menyimpan Transaksi',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getAllDataOrders()
    {
        $transactions = TransOrder::with(['customer', 'details.service'])->get();
        $data = $transactions->map(function ($trx) {
            return [
                'id' => $trx->order_code,
                'customer' => [
                    'id' => $trx->customer->id ?? null,
                    'name' => $trx->customer->customer_name ?? null,
                    'phone' => $trx->customer->phone ?? null,
                    'address' => $trx->customer->address ?? null,
                ],
                'items' => $trx->transOrderDetails->map(function ($orderDetail) {
                    return [
                        'id' => $orderDetail->id,
                        'service' => $orderDetail->service->service_name ?? null,
                        'weight' => $orderDetail->qty,
                        'price' => $orderDetail->service->price,
                        'subtotal' => $orderDetail->subtotal,
                        'notes' => $orderDetail->notes ?? null
                    ];
                }),
                'total' => $trx->total,
                'date' => $trx->order_date,
                'status' => $trx->getStatusTextAttribute(),
                'order_status' => $trx->order_status,
            ];
        });
        return response()->json($data);
    }

    /**
     * Menghapus transaksi.
     */
    public function destroy(string $id)
    {
        $order = TransOrder::findOrFail($id);
        $order->delete();

        Alert::success('Berhasil!', 'Transaksi berhasil dihapus');
        return redirect()->route('transaksi.index');
    }

    public function newStore(Request $request)
    {
        // return $request;
        $request->validate([
            'id'           => 'required|string',
            'customer.id'  => 'required|exists:customers,id',
            'items'        => 'required|array|min:1',
            'total'        => 'required|numeric',
            'order_date'   => 'required|date',
            'order_status' => 'required|bool'
        ]);

        DB::beginTransaction();
        try {
            // Simpan order
            $order = TransOrder::create([
                'order_code'    => $request->id,
                'id_customer'   => $request->customer['id'],
                'order_date'    => $request->order_date,
                'order_end_date'=> Carbon::now()->toDateString(),
                'order_status'  => $request->order_status,
                'total'         => $request->total,
            ]);
            return response()->json($order);

            // Simpan detail item
            foreach ($request->items as $item) {
                TransOrderDetail::create([
                    'id_order'   => $order->id,
                    'id_service' => $item['id_service'],
                    'qty'        => $item['qty'],
                    'price'      => $item['price'],
                    'subtotal'   => $item['subtotal'],
                    'notes'      => $item['notes'] ?? null,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data'    => $order->load('transOrderDetails.typeOfService', 'customer')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function newTransaction(){
        $customer = Customer::all();
        $service = TypeOfService::all();
        return view('admin.transaksi.form_transaksi', compact('customer', 'service'));
    }

    public function pickupLaundry(Request $request, $id) {
        $request->validate([
            'order_status' => 'required|in:0,1' // misalnya ada banyak status
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $order = TransOrder::find($id);

                $order->update([
                    'order_pay' => $order->total,
                    'order_status' => $request->order_status,
                    'order_end_date' => Carbon::now()->toDateString(),

                ]);

                if ($request->order_status == 1) {
                    TransLaundryPickup::create([
                        'id_order' => $order->id,
                        'id_customer' => $order->id_customer,
                        'pickup_date' => Carbon::now(),
                        'notes' => $request->notes ?? null,
                    ]);
                }
            });

            return redirect()->route('transaksi.index');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error' . $th->getMessage(),
            ], 500);
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Pelanggan Laundry';
        $customers = Customer::all();
        return view('admin.pelanggan.index', compact('title', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Data Pelanggan';
        $customers = Customer::all();
        return view('admin.pelanggan.create', compact('title', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Customer::create([
            'customer_name'=>$request->customer_name,
            'phone'=>$request->phone,
            'address'=>$request->address,
        ]);
        Alert::success('Excellent', 'Add customer data successfully');
        return redirect()->to('pelanggan')->with('success', 'Add service data successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Ubah Data Pelanggan';
        $customers = Customer::find($id);
        return view('admin.pelanggan.edit', compact('title', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datas = Customer::find($id);

        $datas->update([
        'customer_name' => $request->customer_name,
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    Alert::success('Excellent', 'Update data customer successfully');
    return redirect()->to('pelanggan')->with('success', 'Update data customer successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::find($id)->delete();
        toast('Delete data customer successfully', 'success');
        return redirect()->to('pelanggan')->with('success', 'Delete data customer successfully');
    }
}
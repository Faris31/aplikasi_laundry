@extends('app')
@section('title', 'Transaksi')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h3 class="card-title">{{ $title ?? '' }}</h3>
                    </div>
                    <div class="col" align="right">
                        <a href="{{ route('transaksi.form_transaksi') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Transaksi
                        </a>
                    </div>
                </div>
                <table class="table table-valign-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomo Pesanan</th>
                            <th>Pemesan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Tanggal Ambil Pesanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transOrders as $index => $order )
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td> <a href="{{ route('transaksi.form_transaksi') }}" class="text-primary fw-bold">
                                    {{ $order->order_code }}
                                </a></td>
                            <td>{{ $order->customer->customer_name ?? '-' }}</td>
                            <td>{{ date('d F Y', strtotime($order->order_date)) }}</td>
                            <td>{{ date('d F Y', strtotime($order->order_end_date)) }}</td>
                            <td>
                                <span class="badge {{ $order->order_status == 0 ? 'badge-info' : 'badge-success' }}">{{ $order->status_text }}</span>
                            </td>
                            <td>
                                <form class="d-inline" action="{{ route('transaksi.pickupLaundry', $order->id) }}" method="post">
                                    @csrf
                                    @method("PUT")
                                    <button type="submit" href="" class="btn btn-warning btn-sm">Pick Up</button>
                                    <input type="hidden" name="order_status" value="1">
                                </form>

                                <a href="{{ url('transaksi/print', $order->id) }}" class="btn btn-success btn-sm">Print</a>

                                <form action=" {{ route('transaksi.destroy', $order->id) }}" method="post" id="delete-form-{{ $order->id }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmAndDelete({{ $order->id }})">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

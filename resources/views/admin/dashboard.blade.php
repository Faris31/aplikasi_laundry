@extends('app')
@section('title', 'Selamat Datang Di Laundry System')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <div class="col">
                        <h3 class="card-header text-bold" align="center">Dashboard</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-bold" align="center">Data User</h3>
                                <div class="table-responsive">
                                    <table class="table table-stripped">
                                        <tr>
                                            <th>Name</th>
                                            <td>:</td>
                                            <td>{{ auth()->user()->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Level</th>
                                            <td>:</td>
                                            <td>{{ auth()->user()->level->level_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>:</td>
                                            <td>{{ auth()->user()->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Login</th>
                                            <td>:</td>
                                            <td>{{ auth()->user()->created_at->format('d F Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-bold" align="center">Data Order</h3>
                                <div class="table-responsive">
                                    <table class="table table-stripped text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Code</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ $order->customer->customer_name }}</td>
                                                <td>
                                                    <span class="badge {{ $order->order_status == 0 ? 'badge-info' : 'badge-success' }}">{{ $order->status_text }}</span>
                                                </td>
                                                <td>Rp {{ number_format($order->total) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Small Box (Stat card) -->
<div class="row">
    <div class="col-lg col-6">
        <!-- small card -->
        <h5 class="text-black text-center text-bold ">Data Pelanggan</h5>
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $customers->count() }}</h3>
                {{-- <p>Data Pelanggan</p> --}}
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('pelanggan.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg col-6">
        <!-- small card -->
        <h5 class="text-black text-center text-bold">Data Layanan</h5>
        <div class="small-box bg-info">
            <div class="inner text-center d-flex">
                <h3>{{ $services->count() }}</h3>
                {{-- <p>Data Services</p> --}}
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('service.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg col-6">
        <!-- small card -->
        <h5 class="text-black text-center text-bold">Data User</h5>
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $users->count() }}</h3>
                {{-- <p>New Orders</p> --}}
            </div>
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
            <a href="{{ route('user.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

@endsection

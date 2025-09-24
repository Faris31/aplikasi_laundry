@extends('app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mb-4">
                        <h5 class="card-title text-bold">Report Transaction Order</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="mb-3">
                        <form action="{{ route('report.index') }}" method="post" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="" class="form-label">Date Start</label>
                                    <input type="date" name="date_start" class="form-control" value="" required>
                                    <div class="invalid-feedback">Please select start date!</div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="" class="form-label">Date End</label>
                                    <input type="date" name="date_end" class="form-control" value="" required>
                                    <div class="invalid-feedback">Please select end date!</div>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <button type="submit" name="filter" class="btn btn-primary btn-sm">
                                        <i class="fas fa-search mr-1"></i>
                                        Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-datatable pt-0">
                        <div class="mb-3" align="right">
                            <a href="{{ url('report/print', $orders) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-print mr-1"></i>
                                Print</a>
                        </div>
                        <table class="table table-bordered datatable text-center">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('report.print', $order->id) }}" target="_blank">
                                            {{ $order->order_code ?? '' }}
                                        </a>
                                    </td>
                                    <td>{{ $order->customer->customer_name  ?? ''}}</td>
                                    <td>{{ date('d F Y', strtotime($order->order_date)) ?? ''}}</td>
                                    <td><span
                                            class="badge {{ $order->status_class }}">{{ $order->status_text ?? '' }}</span>
                                    </td>
                                    <td>Rp {{ number_format($order->total) ?? '' }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                            {{-- <th colspan="4" class="text-right">Jumlah Keseluruhan</th>
                            <th>Rp. {{ number_format($order->subtotal, 0, ',', '.') }}</th> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

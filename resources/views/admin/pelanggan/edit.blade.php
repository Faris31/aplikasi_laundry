@extends('app')
@section('title', 'Ubah Data Customer')
@section('content')
<div class="row">
    <div class="col-lg">
         <div class="card">
             <div class="card-body">
                <div class="row mb-5">
                    <div class="col">
                        <h3 class="card-title text-bold">{{$title ?? ''}}</h3>
                    </div>
                </div>
                <form action="{{route('pelanggan.update', $customers->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="customer_name">Nama Pelanggan <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control"
                                    placeholder="Silahkan masukan nama" value={{ $customers->customer_name }}>
                            </div>
                            <div class="mb-3">
                                <label for="phone">No. HP <span class="text-danger">*</span></label>
                                <input type="number" name="phone" id="phone" class="form-control"
                                    placeholder="Silahkan masukan nomor" value={{ $customers->phone }}>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-">Alamat <span class="text-danger">*</span></label>
                                <textarea name="address" id="address" cols="30" rows="10" class="form-control">{{ $customers->address }}</textarea>
                            </div>
                            <div class="mb-3" align="right ">
                                <a href="{{url()->previous()}}" class="btn btn-outline-primary text-white">
                                    <i class="fas fa-reply mr-2"></i>
                                    Kembali
                                </a>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-envelope-open-text mr-2"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

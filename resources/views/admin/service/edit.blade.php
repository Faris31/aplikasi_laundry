@extends('app')
@section('title', 'Ubah Jenis Layanan')
@section('content')
<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title mb-5 text-bold">Ubah Jenis Layanan</h3>
                    </div>
                </div>
                <form action="{{route('service.update', $edit->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="service_name" class="form-label">Jenis Service <span
                                class="text-danger">*</span></label>
                        <input type="text" name="service_name" id="service_name" class="form-control"
                            value="{{$edit->service_name}}">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" class="form-control" value="{{$edit->price}}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" cols="30" rows="10"
                            class="form-control">{{$edit->description}}</textarea>
                    </div>
                    <div class="mb-4" align="right">
                        <a href="{{url()->previous()}}" class="btn btn-light btn-sm shadow">
                            <i class="fas fa-reply mr-2"></i>
                            Kembali
                        </a>
                        <button type="submit" name="simpan" class="btn btn-primary btn-sm">
                            <i class="fas fa-envelope-open-text"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

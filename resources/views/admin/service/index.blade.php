@extends('app')
@section('title', 'Jenis Layanan')
@section('content')
<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h3 class="card-title">{{$title ?? ''}}</h3>
                    </div>
                    <div class="col" align='right'>
                        <a href="{{route('service.create')}}" class="btn btn-info btn-sm">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Jenis Layanan
                        </a>
                    </div>
                </div>
                <table class="table table-valign-middle text-center rounded">
                    <thead>
                        <tr>
                            <th style="width: 70px">No</th>
                            <th>Servis</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th style="width: 210px">Aksi</th>
                        </tr>
                    </thead>
                    @foreach ( $services as $index => $service)
                    <tbody>
                        <tr>
                            <td>{{$index +=1}}</td>
                            <td>{{$service->service_name}}</td>
                            <td>{{$service->price}}</td>
                            <td>{{$service->description}}</td>
                            <td>
                                <a href="{{route('service.edit', $service->id)}}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt  mr-1"></i>
                                    Ubah
                                </a>
                                <form action="{{route('service.destroy', $service->id)}}" class="d-inline" method="post">
                                    @csrf
                                    @method('delete')
                                    <button href="" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data?')">
                                        <i class="fas fa-trash-alt"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

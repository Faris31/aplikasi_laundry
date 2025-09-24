@extends('app')
@section('title','Pelanggan')
@section('content')
<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h3 class="card-title"> {{ $title}} </h3>
                    </div>
                    <div align="right" class="col">
                        <a href=" {{ route('pelanggan.create') }} " class="btn btn-info btn-sm">
                            <i class="fas fa-plus mr-2"></i>Tambah Data Pelanggan</a>
                    </div>
                </div>
                <table id="example1" class="table table-valign-middle">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $index => $customer )
                        <tr class="text-center">
                            <td style="width: 30px">{{ $index += 1 }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td style="width: 180px">
                                <a class="btn btn-info btn-sm" href=" {{route('pelanggan.edit',  $customer->id)}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Ubah
                                </a>

                                <form action=" {{route('pelanggan.destroy',  $customer->id)}}" method="post" onclick="return confirm('Yakin hapus data?')" class="
                                d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection

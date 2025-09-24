@extends('app')
@section('title', 'Data User')
@section('content')
<div class="row">
    <div class="col-lg">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col mb-3">
                    <h3 class="card-title text-align-center"> {{ $title}} </h3>
                    <div align="right" class="">
                        <a href=" {{ route('user.create') }} " class="btn btn-info btn-sm">
                            <i class="fas fa-plus mr-2"></i>Tambah Data User</a>
                    </div>
                </div>
                <table class="table table-">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $val => $user )
                        <tr class="text-center">
                            <td style="width: 30px">{{$val += 1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                             <span class="badge badge-primary">
                            {{$user->level->level_name}}
                            </span>
                            </td>
                            <td style="width: 180px">
                                <a class="btn btn-info btn-sm" href="{{route('user.edit', $user->id)}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Ubah
                                </a>
                                <form action="{{route('user.destroy', $user->id)}}" method="post" onclick="return confirm('Yakin hapus data?')" class="
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

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection

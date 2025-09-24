@extends('app')
@section('title', 'Tambah Data User')
@section('content')

<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col">
                        <h3 class="card-title text-bold">{{$title ?? ''}}</h3>
                    </div>
                </div>
                <form action="{{route('user.update', $edit->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="name">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Silahkan masukan nama" value="{{$edit->name}}">
                            </div>
                            <div class="mb-3">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Silahkan masukan email" value="{{$edit->email}}">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-">Role</label>
                                <select name="id_level" id="id_level" class="form-control text-muted">
                                    <option value="">-- Pilih Role --</option>
                                    @foreach ($levels as $level )
                                    <option {{$level->id == $edit->id_level ? 'selected' : ''}} value="{{$level->id}}">{{$level->level_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Silahkan masukan password">
                                    <small class="text-danger">
                                        )*silahkan isi password jika ingin merubahnya
                                    </small>
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

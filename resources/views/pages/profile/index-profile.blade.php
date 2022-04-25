@extends('layouts.app')

@section('content')
  <div class="container-fluid">

    {{-- Start breadcrumb --}}
    <div class="page-titles">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="/profile">Profile</a></li>
      </ol>
    </div> 
    {{-- End breadcrumb --}}

    {{-- Start card --}}
    <div class="row">
      <div class="col-lg-12">

        @foreach(['success','danger'] as $msg)
        @if ($message = Session::has($msg))
        <div class="mt-2 mb-2">
          <div class="alert alert-{{$msg}} alert-dismissible">
            {{ Session::get($msg) }}
          </div>
        </div>
        @endif
      @endforeach

      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

        <div class="card">
          <div class="card-header border-0 pb-0">
            <h3 class="card-title">Edit Profile</h3>
          </div>
          <div class="card-body">
            <div class="basic-form">
              <form action="{{ url('/update-profile/'.$user->id) }}" method="POST">
                @csrf
                @method('patch')
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="nama">Nama</label>
                  <div class="col-sm-9">
                    <input type="text" name="nama" value="{{ $user->name }}" class="form-control" id="nama" placeholder="Nama">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="email">Email</label>
                  <div class="col-sm-9">
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="email" placeholder="Email">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="username">Username</label>
                  <div class="col-sm-9">
                    <input type="text" name="username" value="{{ $user->username }}" class="form-control" id="username" placeholder="Username">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="password">Password</label>
                  <div class="col-sm-9">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="password-confirmation">Konfirmasi Password</label>
                  <div class="col-sm-9">
                    <input type="password" name="password_confirmation" class="form-control" id="password-confirmation" placeholder="Konfirmasi Password">
                  </div>
                </div>
                <div class="form-group text-end">
                  <button type="submit" class="btn light btn-info text-uppercase">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- End card --}}

  </div>
@endsection
@extends('layouts.app')

@section('style')
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="container-fluid">
    {{-- Start breadcrumb --}}
      <div class="page-titles">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
          <li class="breadcrumb-item active"><a href="/jabatan">Jabatan</a></li>
        </ol>
      </div>
    {{-- End breadcrumb --}}

      {{-- Start alert message --}}
        @foreach(['success','danger'] as $msg)
        @if ($message = Session::has($msg))
        <div class="mt-2">
          <div class="alert alert-{{$msg}} alert-dismissible fade show shadow-none" role="alert">
            {{ Session::get($msg) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
        @endif
      @endforeach
      {{-- End alert message --}}

    {{-- Start card --}}
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row" style="width: 100%">
                <div class="col-6">
                  <h4 class="card-title text-uppercase">data jabatan</h4>
                </div>
                <div class="col-6 text-end">
                  <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalTambahJabatan" id="jabatanCreateModalButton"><i class="bi bi-plus"></i> Jabatan</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              @if (session('status'))
                <div class="alert alert-success" role="alert">
                  {{ session('status') }}
                </div>
              @endif
              <div class="table-responsive">
                {{ $dataTable->table() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    {{-- End card --}}

    {{-- Start modal tambah jabatan --}}
    @include('pages.jabatan.modals.tambah-jabatan')
    {{-- End modal tambah jabatan --}}

    {{-- Start modal ubah jabatan --}}
    @include('pages.jabatan.modals.ubah-jabatan')
    {{-- End modal ubah jabatan --}}
  </div>
@endsection

@section('script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}"></script>
{{ $dataTable->scripts() }}
<script src="{{ asset('js/jabatan.js') }}"></script>
@endsection
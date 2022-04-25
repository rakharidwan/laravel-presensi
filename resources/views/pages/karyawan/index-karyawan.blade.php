@extends('layouts.app')

@section('style')
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
  .foto-karyawan img {
    width: 100px;
  }
</style>
@endsection

@section('content')
  <div class="container-fluid">
    {{-- Start breadcrumb --}}
      <div class="page-titles">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
          <li class="breadcrumb-item active"><a href="/karyawan">Karyawan</a></li>
        </ol>
      </div>
    {{-- End breadcrumb --}}

    {{-- Start card --}}
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row" style="width: 100%">
                <div class="col-6">
                  <h4 class="card-title text-uppercase">data karyawan</h4>
                </div>
                <div class="col-6 text-end">
                  <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalTambahKaryawan" id="karyawanCreateModalButton"><i class="bi bi-plus"></i> Karyawan</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                {{$dataTable->table()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    {{-- End card --}}

    {{-- Start modal tambah karyawan --}}
    @include('pages.karyawan.modals.tambah-karyawan')
    {{-- End modal tambah jabatan --}}

    {{-- Start modal ubah karyawan --}}
    @include('pages.karyawan.modals.ubah-karyawan')
    {{-- End modal ubah karyawan --}}
  </div>
@endsection

@section('script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}"></script>
{{ $dataTable->scripts() }}
<script src="{{ asset('js/karyawan.js') }}"></script>
@endsection
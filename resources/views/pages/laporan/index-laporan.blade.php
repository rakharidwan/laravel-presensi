@extends('layouts.app')

@section('style')
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<!-- Clockpicker -->
<link href="{{ asset('assets/plugins/clockpicker/css/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
<!-- asColorpicker -->
<link href="{{ asset('assets/plugins/jquery-asColorPicker/css/asColorPicker.min.css') }}" rel="stylesheet">
<!-- Material color picker -->
<link href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<!-- Pick date -->
<link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/default.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/default.date.css') }}">
@endsection

@section('content')
  <div class="container-fluid">
    {{-- Start breadcrumb --}}
      <div class="page-titles">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
          <li class="breadcrumb-item active"><a href="/laporan">laporan</a></li>
        </ol>
      </div>
    {{-- End breadcrumb --}}

    {{-- Start card --}}
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form action="{{ url('/laporan') }}" method="get">
                <div class="form-row">
                  <div class="col-sm-3">
                    <select class="mr-sm-2" name="karyawan" id="inlineFormCustomSelect">
                      <option>-- Pilih karyawan --</option>
                      <option value="all">Semua</option>
                      @forelse ($karyawan as $k)
                      <option value="{{ $k->id }}">{{ $k->nama }} <span class="text-success">({{ $k->entitas }})</span></option>
                      @empty
                          <option value="">Data Karyawan Kososng</option>
                      @endforelse
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <input class="datepicker-default form-control" id="datepicker" name="from" placeholder="Dari tanggal">
                  </div>
                  <div class="col-sm-3">
                    <input  class="datepicker-default form-control" id="datepicker2" name="to" placeholder="Sampai tanggal">
                  </div>
                  <div class="col-sm-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-info me-2">Filter</button>
                    @if ($absensi->isEmpty())
                    <button type="button" onclick="exportExcel()" class="btn btn-outline disabled">Export</button>
                    @else
                    <button type="button" onclick="exportExcel()" class="btn btn-outline-primary">Export</button>
                    @endif
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <form action="{{ url('/laporan/export') }}" id="exportForm" method="post">
        @csrf
        <input type="hidden" name="karyawan" value="{{ request('karyawan') }}">
        <input type="hidden" name="from" value="{{ request('from') }}">
        <input type="hidden" name="to" value="{{ request('to') }}">
      </form>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title text-uppercase">laporan presensi</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="display min-w850" id="example">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Entitas</th>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Tanggal</th>
                      <th>Jam Masuk</th>
                      <th>Jam Keluar</th>
                      <th>Keterangan</th>
                      <th>Keterlambatan</th>
                      <th>Pesan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($absensi as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @foreach($a->karyawan as $karyawan)
                          <td>{{ $karyawan->entitas }}</td>
                          <td>{{ $karyawan->nama }}</td>
                          <td>{{ $karyawan->jabatan->jabatan }}</td>
                          <td>{{ date('d/m/Y', strtotime($karyawan->created_at)); }}</td>
                          @endforeach
                          <td>{{ $a->jam_masuk }}</td>
                          <td>{{ $a->jam_keluar }}</td>
                          <td>{{ $a->keterangan }}</td>
                          <td>{{ $a->keterlambatan }} Menit</td>
                          <td>{{ $a->pesan }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    {{-- End card --}}
  </div>
@endsection

@section('script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}"></script>
<!-- pickdate -->
<script src="{{ asset('assets/plugins/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('assets/plugins/pickadate/picker.date.js') }}"></script>
<!-- Daterangepicker -->
<script src="{{ asset('assets/js/plugins-init/bs-daterange-picker-init.js') }}"></script>
<!-- Clockpicker init -->
<script src="{{ asset('assets/js/plugins-init/clock-picker-init.js') }}"></script>
<!-- asColorPicker init -->
<script src="{{ asset('assets/js/plugins-init/jquery-asColorPicker.init.js') }}"></script>
<!-- Material color picker init -->
<script src="{{ asset('assets/js/plugins-init/material-date-picker-init.js') }}"></script>
<!-- Pickdate -->
<script src="{{ asset('assets/js/plugins-init/pickadate-init.js') }}"></script>
<script>
  function exportExcel() {
  document.getElementById("exportForm").submit();
}
</script>
@endsection
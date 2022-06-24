@extends('layouts.app')

@section('style')
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/default.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/default.date.css') }}">
<style>
  .foto-presensi img {
    width: 100px;
    cursor: pointer;
    transition: 0.2s;
  }

  .foto-presensi img.big-size {
    position: relative;
    transform: scale(3);
  }
</style>
@endsection

@section('content')
  <div class="container-fluid">
    {{-- Start breadcrumb --}}
      <div class="page-titles">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
          <li class="breadcrumb-item active"><a href="/presensi">presensi</a></li>
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
                  <h4 class="card-title text-uppercase">Presensi Karyawan {{ date('d F Y', strtotime($waktu)); }} </h4>
                </div>
                <div class="col-6">
                  <form action="{{ url('/absensi') }}" method="get" class="d-flex justify-content-end">
                    <input name="date" class="datepicker-default form-control" id="datepicker" style="width: 50%" placeholder="Masukan tanggal">
                    <button type="submit" class="btn btn-success ms-3">Cari</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="display min-w850" id="example3">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Masuk</th>
                      <th>Pulang</th>
                      <th>Keterangan</th>
                      <th>Datang</th>
                      <th>Pulang</th>
                      <th>Pesan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($absensi as $absen)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      @foreach ($absen->karyawan as $karyawan)
                        <td>{{ $karyawan->nama }} <span class="text-info">({{ $karyawan->entitas }})</span></td>
                      @endforeach
                      <td>{{ $absen->jam_masuk }}</td>
                      @if ($absen->jam_keluar == null)
                        <td>Belum Pulang</td>
                      @else
                        <td>{{ $absen->jam_keluar }}</td>
                      @endif
                      @if ($absen->keterangan == 'TELAT')
                        <td><span class="badge badge-pill badge-danger">{{ $absen->keterangan }} {{ floor($absen->keterlambatan / 60) }} jam {{ $absen->keterlambatan % 60 }} menit</span></td>
                      @elseif($absen->keterangan == 'HADIR')
                        <td><span class="badge badge-pill badge-primary">{{ $absen->keterangan }} {{ $absen->keterlambatan }}</span></td>
                      @else
                        <td><span class="badge badge-pill badge-primary">{{ $absen->keterangan }}</span></td>
                      @endif
                      <td>
                        <div class="foto-presensi">
                          <img src="{{ asset('storage/' . $absen->foto) }}" onclick="perbesarUkuran(event)" alt="Foto selfie">
                        </div>
                      </td>
                      <td><div class="foto-presensi">
                        <img src="{{ asset('storage/' . $absen->foto_pulang) }}" onclick="perbesarUkuran(event)" alt="Foto selfie">
                      </div></td>
                      <td>{{ $absen->pesan }}</td>
                      <td>
                        @if($absen->status_ubah == 0)
                        <div class="basic-dropdown">
                          <div class="dropdown">
                            <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                              Tindakan
                            </button>
                            <div class="dropdown-menu">
                              <form action="{{ url('/absensi/ganti-status/'.$absen->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="dropdown-item" type="submit" value="HADIR" name="action"><i class="bi bi-check-all text-primary"></i> Masuk</button>
                                <button class="dropdown-item" type="submit" value="IZIN" name="action"><i class="bi bi-check2 text-info"></i> Izin</button>
                                <button class="dropdown-item" type="submit" value="SAKIT" name="action"><i class="bi bi-check2 text-info"></i> Sakit</button>
                                <button class="dropdown-item" type="submit" value="LIBUR" name="action"><i class="bi bi-check2 text-info"></i> Libur</button>
                                <button class="dropdown-item" type="submit" value="CUTI" name="action"><i class="bi bi-check2 text-info"></i> Cuti</button>
                                <button class="dropdown-item" type="submit" value="TANPA KETERANGAN" name="action"><i class="bi bi-x-lg text-danger"></i> Tanpa Keterangan</button>
                              </form>
                            </div>
                          </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @forelse($not_yet_absent as $nya)
                    <tr>
                      <td>{{ $loop->iteration + $absensi->count(); }}</td>
                      <td>{{ $nya->nama }} ( {{ $nya->entitas }} )</td>
                      <td>00:00:00</td>
                      <td>00:00:00</td>
                      <td>Belum Melakukan Absensi</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>
                        <div class="basic-dropdown">
                          <div class="dropdown">
                            <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                              Tindakan
                            </button>
                            <div class="dropdown-menu">
                              <form action="{{ url('/absensi/absent-manual/'.$nya->id.'/'.date('Y-m-d', strtotime($waktu))) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="dropdown-item" type="submit" value="HADIR" name="action"><i class="bi bi-check-all text-primary"></i> Masuk</button>
                                <button class="dropdown-item" type="submit" value="IZIN" name="action"><i class="bi bi-check2 text-info"></i> Izin</button>
                                <button class="dropdown-item" type="submit" value="SAKIT" name="action"><i class="bi bi-check2 text-info"></i> Sakit</button>
                                <button class="dropdown-item" type="submit" value="LIBUR" name="action"><i class="bi bi-check2 text-info"></i> Libur</button>
                                <button class="dropdown-item" type="submit" value="CUTI" name="action"><i class="bi bi-check2 text-info"></i> Cuti</button>
                                <button class="dropdown-item" type="submit" value="TANPA KETERANGAN" name="action"><i class="bi bi-x-lg text-danger"></i> Tanpa Keterangan</button>
                              </form>
                            </div>
                          </div>

                      </td>
                    </tr>
                    @empty
                    @endforelse
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
<!-- pickdate -->
<script src="{{ asset('assets/plugins/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/pickadate/picker.date.js') }}"></script>
<!-- Pickdate -->
<script src="{{ asset('assets/js/plugins-init/pickadate-init.js') }}"></script>
<script>
  const dateTitle = document.querySelector('.date-title')
  const inputTanggal = document.getElementById('datepicker')
  const sekarang = new Date()
  let tahun = sekarang.getFullYear()
  let bulan = sekarang.getMonth()
  let hari = sekarang.getDate()
  let bulans = [
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  ]

  const tanggal = `${hari} ${bulans[bulan]}, ${tahun}`

  dateTitle.innerHTML = `${hari} ${bulans[bulan]} ${tahun}`

  function perbesarUkuran(event) {
    event.target.classList.toggle('big-size')
  }
</script>
@endsection
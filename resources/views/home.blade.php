@extends('layouts.app')

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection

@section('content')
  <div class="container-fluid">
    <div class="form-head d-flex mb-3 mb-md-4 align-items-start">
      <div class="d-none d-lg-block">
        <h3 class="text-block font-w600">Selamat datang {{ Auth::user()->name }}</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-4 col-lg-4 col-md-6 col-12">
        <a href="/karyawan">
          <div class="card gradient-bx text-white bg-info rounded">
            <div class="card-body">
              <div class="media align-items-center">
                <div class="media-body">
                  <p class="mb-1">Total Karyawan</p>
                  <div class="d-flex flex-wrap">
                    <h2 class="fs-40 font-w600 text-white mb-0 mr-3">{{ $jumlah_karyawan }}</h2>
                  </div>
                </div>
                <span class="card-icon border rounded-circle pt-3 pb-3 ps-4 pe-4">
                  <i class="bi bi-people"></i>
                </span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-6 col-12">
        <div class="card gradient-bx text-white bg-success rounded">
          <div class="card-body">
            <div class="media align-items-center">
              <div class="media-body">
                <p class="mb-1">Sudah Presensi</p>
                <div class="d-flex flex-wrap">
                  <h2 class="fs-40 font-w600 text-white mb-0 mr-3" id="absentEntry"></h2>
                </div>
              </div>
              <span class="card-icon border rounded-circle pt-3 pb-3 ps-4 pe-4">
                <i class="bi bi-check-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-6 col-12">
        <div class="card gradient-bx text-white bg-danger rounded">
          <div class="card-body">
            <div class="media align-items-center">
              <div class="media-body">
                <p class="mb-1">Belum Presensi</p>
                <div class="d-flex flex-wrap">
                  <h2 class="fs-40 font-w600 text-white mb-0 mr-3" id="absentNotYet"></h2>
                </div>
              </div>
              <span class="card-icon border rounded-circle pt-3 pb-3 ps-4 pe-4">
                <i class="bi bi-x-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header border-0 pb-0">
            <h3 class="fs-20 mb-0 text-black">100 karyawan telah melakukan presensi hari ini</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-responsive-sm">
                <tbody id="absentRealTime">
                 
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer border-0 pt-0 text-center">
            <a href="/absensi" class="card-link">Selengkapnya <i class="bi bi-arrow-bar-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/date_format.js') }}"></script>
    <script>

      dataAbsent();
      function dataAbsent(){
        function timeConvert(n) {
          var num = n;
          var hours = (num / 60);
          var rhours = Math.floor(hours);
          var minutes = (hours - rhours) * 60;
          var rminutes = Math.round(minutes);
          return rhours + " Jam " + rminutes + " Menit";
          }
        $.ajax({
          url: '/data-absent',
          method: 'GET',
          success: function(data){
            $.each(data.absent, function( index, value ) {
              let t = new Date(value.created_at);
              // console.log(t);
              let status_pulang = 'Belum Pulang'
              if (value.jam_keluar != null){
                status_pulang = 'Sudah Pulang'
              }
              const date = ('0' + t.getDate()).slice(-2);
              const month = ('0' + (t.getMonth() + 1)).slice(-2);
              const year = t.getFullYear();
              const hours = ('0' + t.getHours()).slice(-2);
              const minutes = ('0' + t.getMinutes()).slice(-2);
              const seconds = ('0' + t.getSeconds()).slice(-2);
              const time = `${hours}:${minutes}:${seconds}`;
              console.log();
              $.each(value.karyawan, function( k, karyawan ) {
                $("#absentRealTime").append(`
                    <tr>
                      <th><i class="bi bi-person-check-fill"></i></th>
                      <td><span class="text-info">`+karyawan.nama+`</span> - <span>`+karyawan.entitas+`</span></td>
                      
                      <td><i>Masuk `+time+` `+status_pulang+` (TELAT `+timeConvert(value.keterlambatan)+`)</i></td>
                    </tr>
                `)
              })
            });
          }
        })
      }

    </script>
@endsection

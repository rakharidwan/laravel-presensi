<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

   {{-- Favicon --}}
   <link rel="icon" href="{{ asset('assets/images/logo/logo-itop-pendek.png') }}" type="image/png" />


  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('assets/js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  {{-- Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <!-- Styles -->
  <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
</head>
<body onload="initClock()">
  <div id="app">
    <div class="page-presensi" id="page-presensi">
      {{-- Start clock --}}
      <div class="datetime">
        <div class="date">
          <span id="dayname">Day</span>,
          <span id="daynum">00</span>
          <span id="month">Month</span>
          <span id="year">Year</span>
        </div>
        <div class="time">
          <span id="hour">00</span>:
          <span id="minutes">00</span>:
          <span id="seconds">00</span>
          <span id="period">AM</span>
        </div>
      </div>
      {{-- End clock --}}

      {{-- Start form presensi --}}
      <div class="">
        <div class="form-presensi" id="form-presensi">
          @if ($waktu_sekarang >= $waktu_pulang)
              <form action="{{ url('/pulang') }}" method="post" id="absentForm">
          @else
              <form action="{{ url('/absent') }}" method="post" id="absentForm">
          @endif
          @csrf
            <div id="form-nik" class="form">
              <h3>Masukan nomor NIK Anda</h3>
              <div id="msg">
              </div>
              <input type="text" class="form-input" name="nik" placeholder="NIK" maxlength="13" autofocus>
              <span class="text-danger error-text nik_error" role="alert"></span>
              @if ($waktu_sekarang > $waktu_masuk)
              <input type="text" class="form-input" name="pesan" placeholder="Sampaikan Pesan">
              @endif
              <div class="btn-box">
                <button type="button" id="next-page"><i class="bi bi-arrow-right"></i></button>
              </div>
            </div>
            <div id="form-kamera" class="form">
              <h3>Ambil foto selfie</h3>
              <div class="webcamera">
                  <div id="results" class="result"></div>
                  <div id="my_camera">
                    <div></div>
                    <video autoplay="autoplay" playsinline="playsinline" id="#camera_vidio"></video></div>
                  <script type="text/javascript" src="{{ asset('/plugins/webcamjs-master/webcam.min.js') }}"></script>
                  <div id="js"></div>
              </div>
              <div class="btn-camera d-flex justify-content-center mt-3">
                <button type="button" class="btn_btn-camera" id="btn-camera" onclick="take_snapshot()"><i class="bi bi-camera-fill"></i></button>
                <button type="button" class="btn_btn-camera" id="btn-refresh"><i class="bi bi-arrow-repeat"></i>
                </button>
              </div>
              <input type="hidden" name="photo" id="inputPhoto">
              <div class="btn-box">
                <button type="button" id="prevButton"><i class="bi bi-arrow-left"></i></button>
                @if ($waktu_sekarang >= $waktu_pulang)
                  <button type="submit" id="absentButton" class="bg-primary">Pulang</button>
                  @else
                    <button type="submit" id="absentButton" class="bg-primary">Masuk</button>
          @endif
              </div>
            </div>
          </form>
          <div class="step-row">
            <div id="progress"></div>
            <div class="step-col"><small id="step1">Step 1</small></div>
            <div class="step-col"><small id="step2">Step 2</small></div>
          </div>
        </div>
      </div>
      {{-- End form presensi --}}

      {{-- Start Logo ITOP --}}
      <div class="row mb-5">
        <div class="col text-center">
          <p>
            <small><i>Powered By</i></small>
          </p>
          <img src="{{ asset('assets/images/logo/logo-itop-panjang.png') }}" class="logo-itop" alt="Logo Indifa Teknologi Optima">
        </div>
      </div>
      {{-- End Logo Itop --}}
    </div>
  </div>
  <script>
                             
    function take_snapshot() {
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            // display results in page
            var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
            document.getElementById('inputPhoto').value = raw_image_data;
             document.getElementById('results').innerHTML = 
            '<img src="'+data_uri+'" id="photo" style="width: 60%; height: 280px;"/>';
            document.getElementById('buttonReset').innerHTML =
            '      <input type="button" class="btn btn-primary mt-3" value="Take Snapshot" onclick="take_snapshot()">';
        } );

    }
    </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="{{ asset('assets/js/welcome.js') }}"></script>
  <script src="{{ asset('js/absent.js') }}"></script>

</body>
</html>
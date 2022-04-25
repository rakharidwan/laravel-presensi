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
  <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <!-- Styles -->
  <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  @yield('style')
</head>
<body>
  <div id="app">
    {{-- Start preloader --}}
    <div id="preloader">
      <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
      </div>
    </div>
    {{-- End preloader --}}

    <div id="main-wrapper">
      {{-- Start Nav header --}}
      <div class="nav-header">
        <a href="{{ url('/home') }}" class="brand-logo">
          <img class="logo-abbr" src="{{ asset('assets/images/logo/logo-bo.png') }}" alt="" />
          <img class="logo-compact" src="{{ asset('assets/images/logo/logo-insani-plus.png') }}" alt="" />
          <img class="brand-title" src="{{ asset('assets/images/logo/logo-insani-plus.png') }}" alt="" />
        </a>
        <div class="nav-control">
          <div class="hamburger"><span class="line"></span><span class="line"></span><span class="line"></span></div>
        </div>
      </div>
      {{-- End Nav header --}}

      {{-- Start Header --}}
      @include('layouts.partials.header')
      {{-- End Header --}}

      {{-- Start Sidebar --}}
      @include('layouts.partials.sidebar')
      {{-- End Sidebar --}}

      {{-- Start Content --}}
      <div class="content-body">
        @yield('content')
      </div>
      {{-- End Content --}}
    </div>
    <div class="footer">
      <div class="copyright">
        <p>Copyright © Designed &amp; Developed by <span class="text-info">Indifa Teknologi Optima</span> 2022</p>
      </div>
    </div>
  </div>
  <!-- Required vendors -->
  <script src="{{ asset('assets/plugins/global/global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('assets/js/custom.min.js') }}"></script>
  <script src="{{ asset('assets/js/deznav-init.js') }}"></script>
  @yield('script')
</body>
</html>

<div class="header">
  <div class="header-content">
    <nav class="navbar navbar-expand">
      <div class="collapse navbar-collapse justify-content-between">
        <div class="header-left">
          <div class="dashboard_bar">Itopresence</div>
        </div>
        <ul class="navbar-nav header-right">
          <li class="nav-item dropdown header-profile">
            {{-- Authentication link --}}
            @guest
              @if (Route::has('login'))
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="{{ route('login') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ __('Login') }}
                </a>
            @endif

            @if (Route::has('register'))
              <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="{{ route('register') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ __('Register') }}
              </a>
            @endif

            @else
            <a class="nav-link" href="javascript:;" role="button" data-toggle="dropdown">
              <div class="header-info">
                <span>Hello,<strong> {{ Auth::user()->name }}</strong></span>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ url('/home') }}" class="dropdown-item ai-icon">
                <i class="bi bi-microsoft text-info"></i>
                <span class="ml-2">Dashboard </span>
              </a>
              <a href="{{ url('/edit-profile/' . Auth::user()->id) }}" class="dropdown-item ai-icon">
                <i class="bi bi-person text-info"></i>
                <span class="ml-2">Profile </span>
              </a>
              <a class="dropdown-item ai-icon" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right text-danger"></i>
                <span class="ml-2">{{ __('Logout') }}</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>  
            </div>
            @endguest
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>
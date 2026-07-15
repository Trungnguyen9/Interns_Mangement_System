{{-- ===== HEADER ===== --}}
  <header class="ims-header">
    <a class="ims-logo" href="{{ route('frontend.mentor') }}">
      <div class="logo-icon"><i class="fa-solid fa-people-group"></i></div> IMS
    </a>
    <div class="ims-breadcrumb">
      <i class="fa-solid fa-house" style="font-size:12px"></i>
      <i class="fa-solid fa-chevron-right" style="font-size:10px"></i>
      <span>@yield('breadcrumb', 'Dashboard Mentor')</span> 
    </div>
    <div class="ims-header-right">
      <div class="ims-user-chip">
        <div class="ims-avatar mentor-avatar-accent">{{ strtoupper(substr(auth()->user()->name , 0, 2)) }}</div>
        <span class="ims-user-name">{{ auth()->user()->name }}</span>
      </div>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn-logout">
          <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
        </button>
      </form>
    </div>
  </header>
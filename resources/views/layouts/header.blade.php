
<header class="app-header">
    <div class="main-header-container container-fluid">
        <div class="header-content-left">
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="index.html" class="header-logo">
                        <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
                        <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
                        <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
                    </a>
                </div>
            </div>
            <div class="header-element mx-lg-0 mx-2">
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
            </div>
        </div>
        <div class="header-content-right">
            <div class="header-element d-lg-none d-flex">
                <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#responsive-searchModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                </a>  
            </div>
            <div class="header-element header-theme-mode">
                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><rect fill="none" height="24" width="24"/><path d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27C17.45,17.19,14.93,19,12,19 c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z M12,3c-4.97,0-9,4.03-9,9s4.03,9,9,9s9-4.03,9-9c0-0.46-0.04-0.92-0.1-1.36 c-0.98,1.37-2.58,2.26-4.4,2.26c-2.98,0-5.4-2.42-5.4-5.4c0-1.81,0.89-3.42,2.26-4.4C12.92,3.04,12.46,3,12,3L12,3z"/></svg>
                    </span>
                    <span class="dark-layout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79zM1 10.5h3v2H1zM11 .55h2V3.5h-2zm8.04 2.495l1.408 1.407-1.79 1.79-1.407-1.408zm-1.8 15.115l1.79 1.8 1.41-1.41-1.8-1.79zM20 10.5h3v2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm-1 4h2v2.95h-2zm-7.45-.96l1.41 1.41 1.79-1.8-1.41-1.41z"/></svg>
                    </span>
                </a>
            </div>
            <div class="header-element header-fullscreen">
                <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="full-screen-open header-link-icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="full-screen-close header-link-icon d-none" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/></svg>
                </a>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="header-element">
                    @php
                        $roles = session('user_roles', []);
                        $main = session('main_role');
                        $otherRoles = array_filter($roles, fn($r) => $r !== $main);
                    @endphp
                    @if (count($otherRoles) > 0)
                        <a class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center justify-content-center px-3 py-2 text-white"
                            href="#" id="roleDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            style="background-color: #410681; border-radius: 6px; font-size: 12px;">
                                <i class="lang-txt fa fa-check-square-o me-2"></i>
                                <span class="text-uppercase">{{ $main }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm text-capitalize"
                                aria-labelledby="roleDropdown"
                                style="min-width: 180px; font-size: 12px;">
                                
                                {{-- Header --}}
                                <li>
                                    <h6 class="dropdown-header text-secondary fw-bold text-uppercase small" style="font-size: 12px;">
                                        Change Role
                                    </h6>
                                </li>

                                {{-- List roles excluding current --}}
                                @foreach ($otherRoles as $index => $role)
                                    <li class="{{ $index > 0 ? 'border-top' : '' }}">
                                        <a href="#"
                                        class="dropdown-item d-flex align-items-center"
                                        onclick="changeRole('{{ $role }}'); return false;">
                                            <i class="me-2 text-muted"></i> {{ ucfirst($role) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </a>
                    @else

                        <a class="nav-item">
                            <span class="nav-link d-flex align-items-center justify-content-center px-3 py-2 text-white"
                                style="background-color: #410681; border-radius: 6px; font-size: 12px;">
                                <i class="lang-txt fa fa-check-square-o me-2"></i>
                                <span class="text-uppercase">{{ $main }}</span>
                            </span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="header-element dropdown">
                <a href="javascript:void(0);" 
                    class="header-link dropdown-toggle d-flex align-items-center gap-2" 
                    id="mainHeaderProfile" 
                    data-bs-toggle="dropdown" 
                    data-bs-auto-close="outside" 
                    aria-expanded="false">
                    <span class="avatar avatar-sm avatar-rounded position-relative">
                        <img src="{{ asset('../assets/images/faces/14.jpg') }}" alt="Profile Picture" class="img-fluid rounded-circle">
                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:10px; height:10px;"></span>
                    </span>
                    <div class="d-none d-md-block">
                        <p class="mb-0 fw-semibold lh-1" style="max-width: %100;">
                            {{ Auth::user()->email ?? '' }}
                        </p>
                    </div>
                </a>
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item d-flex align-items-center" href="profile.html"><i class="ti ti-user-circle fs-18 me-2 text-gray fw-normal"></i>My Profile</a></li>
                    <li> <hr class="dropdown-divider"> </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('page.logout') }}"><i class="ti ti-logout fs-18 me-2 text-gray fw-normal"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script>
    function changeRole(role) {
      fetch("{{ route('switch.role') }}", {
          method: "POST",
          headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": '{{ csrf_token() }}'
          },
          body: JSON.stringify({ role: role })
      })
      .then(response => response.json())
      .then(data => {
          if (data.status === 'ok' && data.redirect) {
              window.location.href = data.redirect;
          } else {
              alert("Failed to switch role.");
          }
      })
      .catch(error => {
          console.error("Error:", error);
          alert("An error occurred while switching roles.");
      });
    }

</script>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Search -->
  {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 navbar-search">
      <div class="input-group">
          <input type="text" class="form-control bg-light border-0 small" placeholder="Search for...">
          <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
              </button>
          </div>
      </div>
  </form> --}}

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">
      <!-- Alerts -->
      <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
              <i class="fas fa-bell fa-fw"></i>
              {{-- <span class="badge badge-danger badge-counter">3+</span> --}}
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
              <h6 class="dropdown-header">Alerts Center</h6>
              <!-- Example alert item -->
              {{-- <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                      <div class="icon-circle bg-primary">
                          <i class="fas fa-file-alt text-white"></i>
                      </div>
                  </div>
                  <div>
                      <span class="font-weight-bold">A new monthly report is ready to download!</span>
                      <div class="small text-gray-500">December 12, 2019</div>
                  </div>
              </a> --}}
          </div>
      </li>

      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- User Info -->
      <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::guard('alumni')->user()->nama }}</span>
              <img class="img-profile rounded-circle" src="{{ asset('storage/foto_alumni/' . $alumni->foto) }}">
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
              <a class="dropdown-item" href="{{ route('alumni.profile') }}"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
              <a class="dropdown-item" href="{{ route('alumni.profile.password') }}">
                <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i> Ubah Password
              </a>
              <div class="dropdown-divider"></div>
              <form action="{{ route('alumni.logout') }}" method="POST" class="dropdown-item p-0 m-0">
                @csrf
                <button type="submit" class="btn btn-link dropdown-item text-left">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </button>
            </form>            
          </div>
      </li>
  </ul>
</nav>

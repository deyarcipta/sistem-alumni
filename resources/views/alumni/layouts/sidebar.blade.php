<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
      <div class="sidebar-brand-icon rotate-n-15">
          {{-- <i class="fas fa-laugh-wink"></i> --}}
          <img src="{{ asset('storage/settings/' . $setting->logo) }}" alt="Logo" style="height: 50px;">
      </div>
      <div class="sidebar-brand-text mx-3">ALUMNI <sup>{{$setting->singkatan_sekolah}}</sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">Menu Alumni</div>

    <!-- Menu Alumni -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-download"></i>
            <span>Unduhan</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data Unduhan</h6>
                <a class="collapse-item" href="{{ route('alumni.dokumen.index') }}">Ijazah</a>
                <a class="collapse-item" href="{{ route('alumni.sertifikat.index') }}">Sertifikat</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('alumni.tagihan.index') }}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Tagihan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('alumni.tracer_study.step1') }}">
            <i class="fas fa-fw fa-poll"></i>
            <span>Tracer Study</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-download"></i>
            <span>Legalisir</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data Legalisir</h6>
                <a class="collapse-item" href="{{ route('alumni.legalisir.index') }}">Pengajuan Legalisir</a>
                <a class="collapse-item" href="{{ route('alumni.legalisir.logs') }}">Log Legalisir</a>
            </div>
        </div>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('alumni.legalisir.index') }}">
            <i class="fas fa-fw fa-file-signature"></i>
            <span>Legalisir</span>
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('alumni.buku_wisuda.index') }}">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Buku Wisuda</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('alumni.alumni.index') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Data Alumni</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Event Alumni</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-users"></i>
            <span>Komunitas</span>
        </a>
    </li> --}}

    <!-- Menu Loker -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Menu Loker</div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('alumni.loker.index') }}">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Info Loker</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('alumni.daftar_perusahaan.index') }}">
            <i class="fas fa-fw fa-building"></i>
            <span>Daftar Perusahaan</span>
        </a>
    </li>

    <!-- Sidebar Toggler -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

@php 
    use App\Models\Admin;
    $user = auth('admin')->user(); 
@endphp
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
      <a class="nav-link" href="{{ url('/admin') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">
  {{-- Hanya untuk Super User --}}
  @if($user->role === Admin::ROLE_SUPER)
    <!-- Heading -->
    <div class="sidebar-heading">Menu Admin</div>

        <!-- Menu Alumni -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-download"></i>
                <span>Data Master</span>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Master</h6>
                    <a class="collapse-item" href="{{ route('admin.data-alumni.import.form') }}">Import Data Master</a>
                    <a class="collapse-item" href="{{ route('admin.jurusan.index') }}">Data Jurusan</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.alumni.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Alumni</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Data Dokumen</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Dokumen</h6>
                    <a class="collapse-item" href="{{ route('admin.ijazah.index') }}">Data Ijazah</a>
                    <a class="collapse-item" href="{{ route('admin.sertifikat.index') }}">Data Sertifikat</a>
                    <a class="collapse-item" href="{{ route('admin.dokumen.index') }}">All Dokumen</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tagihan.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Data Tagihan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tracer_study.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Tracer Study</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.legalisir.index') }}">
                <i class="fas fa-fw fa-file-signature"></i>
                <span>Data Legalisir</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.bukuWisuda.index') }}">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Data Buku Wisuda</span>
            </a>
        </li>

        <!-- Menu Loker -->
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Menu BKK</div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.loker.index') }}">
                <i class="fas fa-fw fa-briefcase"></i>
                <span>Data Loker</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.perusahaan.index') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>Data Perusahaan</span>
            </a>
        </li>

        <!-- Menu Setting -->
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Menu Setting</div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Data User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.settings.edit') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>Setting Sistem</span>
            </a>
        </li>
    @endif

    @if($user->role === Admin::ROLE_KEPSEK)
        <!-- Heading -->
        <div class="sidebar-heading">Menu Kepsek</div>

        <!-- Menu Kepsek -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.alumni.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Alumni</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Data Dokumen</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Dokumen</h6>
                    <a class="collapse-item" href="{{ route('admin.ijazah.index') }}">Data Ijazah</a>
                    <a class="collapse-item" href="{{ route('admin.sertifikat.index') }}">Data Sertifikat</a>
                    <a class="collapse-item" href="{{ route('admin.dokumen.index') }}">All Dokumen</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tagihan.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Data Tagihan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tracer_study.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Tracer Study</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.legalisir.index') }}">
                <i class="fas fa-fw fa-file-signature"></i>
                <span>Data Legalisir</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.bukuWisuda.index') }}">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Data Buku Wisuda</span>
            </a>
        </li>

        <!-- Menu Loker -->
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Menu BKK</div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.loker.index') }}">
                <i class="fas fa-fw fa-briefcase"></i>
                <span>Data Loker</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.perusahaan.index') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>Data Perusahaan</span>
            </a>
        </li>
    @endif

    @if($user->role === Admin::ROLE_TU)
        <!-- Heading -->
        <div class="sidebar-heading">Menu TU</div>

        <!-- Menu TU -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.alumni.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Alumni</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Data Dokumen</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Dokumen</h6>
                    <a class="collapse-item" href="{{ route('admin.ijazah.index') }}">Data Ijazah</a>
                    <a class="collapse-item" href="{{ route('admin.sertifikat.index') }}">Data Sertifikat</a>
                    <a class="collapse-item" href="{{ route('admin.dokumen.index') }}">All Dokumen</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tracer_study.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Tracer Study</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.legalisir.index') }}">
                <i class="fas fa-fw fa-file-signature"></i>
                <span>Data Legalisir</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.bukuWisuda.index') }}">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Data Buku Wisuda</span>
            </a>
        </li>
    @endif

    @if($user->role === Admin::ROLE_KEUANGAN)
    <!-- Heading -->
    <div class="sidebar-heading">Menu Keuangan</div>

        <!-- Menu Keuangan -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.alumni.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Alumni</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tagihan.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Data Tagihan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.legalisir.index') }}">
                <i class="fas fa-fw fa-file-signature"></i>
                <span>Data Legalisir</span>
            </a>
        </li>
    @endif
    @if($user->role === Admin::ROLE_BKK)
        <!-- Menu Loker -->
        <div class="sidebar-heading">Menu BKK</div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.alumni.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Alumni</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tracer_study.index') }}">
                <i class="fas fa-fw fa-poll"></i>
                <span>Data Tracer Study</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.loker.index') }}">
                <i class="fas fa-fw fa-briefcase"></i>
                <span>Data Loker</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.perusahaan.index') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>Data Perusahaan</span>
            </a>
        </li>
    @endif

    <!-- Sidebar Toggler -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

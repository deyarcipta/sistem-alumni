@extends('alumni.layouts.app')
@section('title', 'Profile Alumni')
@section('content')
<div class="container">
    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('storage/foto_alumni/' . $profileAlumni->foto) }}" 
                    alt="Foto Alumni" 
                    class="rounded-circle object-fit-cover" 
                    style="width: 150px; height: 150px;">
                    <h5 class="mt-3">{{ $profileAlumni->nama }}</h5>
                    <p>{{ $profileAlumni->jurusan->nama_jurusan }}</p>
                    <form action="{{ route('alumni.updateFoto', $profileAlumni->id_alumni) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Ubah Foto</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-8">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile Alumni</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pendidikan-tab" data-bs-toggle="tab" href="#pendidikan" role="tab" aria-controls="pendidikan" aria-selected="false">Pendidikan</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pengalaman-tab" data-bs-toggle="tab" href="#pengalaman" role="tab" aria-controls="pengalaman" aria-selected="false">Pengalaman Kerja</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="sertifikat-tab" data-bs-toggle="tab" href="#sertifikat" role="tab" aria-controls="sertifikat" aria-selected="false">Sertifikat</a>
                </li>
            </ul>
            <div class="tab-content" id="profileTabContent">
                <!-- Profile Alumni Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-2 d-flex">
                                <div class="fw-bold me-2" style="width: 170px;">NIS</div>
                                <div>: {{ $profileAlumni->nis }}</div>
                            </div>
                            <div class="mb-2 d-flex">
                                <div class="fw-bold me-2" style="width: 170px;">NISN</div>
                                <div>: {{ $profileAlumni->nisn }}</div>
                            </div>
                            <div class="mb-2 d-flex">
                                <div class="fw-bold me-2" style="width: 170px;">Nama</div>
                                <div>: {{ $profileAlumni->nama }}</div>
                            </div>
                            <div class="mb-2 d-flex">
                                <div class="fw-bold me-2" style="width: 170px;">Tempat, Tanggal Lahir</div>
                                <div>: {{ $profileAlumni->tempat_lahir }}, {{ \Carbon\Carbon::parse($profileAlumni->tanggal_lahir)->format('d M Y') }}</div>
                            </div>
                            <div class="mb-2 d-flex">
                                <div class="fw-bold me-2" style="width: 170px;">Jurusan</div>
                                <div>: {{ $profileAlumni->jurusan->nama_jurusan }}</div>
                            </div>
                            <div class="mb-2 d-flex">
                                <div class="fw-bold me-2" style="width: 170px;">Tahun Lulus</div>
                                <div>: {{ $profileAlumni->tahun_lulus }}</div>
                            </div>
                            <div class="mb-2 d-flex">
                                <div class="fw-bold me-2" style="width: 170px;">No Hp</div>
                                <div>: {{ $profileAlumni->no_hp }}</div>
                            </div>
                            <div class="mb-2 d-flex">
                                <div class="fw-bold me-2" style="width: 170px;">Email</div>
                                <div>: {{ $profileAlumni->email }}</div>
                            </div>
                        </div>                        
                    </div>
                </div>

                <!-- Pendidikan Tab -->
                <div class="tab-pane fade" id="pendidikan" role="tabpanel" aria-labelledby="pendidikan-tab">
                    <div class="card mb-3">
                        <div class="card-body">
                            @if(!empty($profileAlumni->sekolah_sd))
                                <div class="mb-2 d-flex">
                                    <div class="fw-bold me-2" style="width: 180px;">SD</div>
                                    <div>: {{ $profileAlumni->sekolah_sd }} (Lulus {{ $profileAlumni->tahun_lulus_sd ?? '-' }})</div>
                                </div>
                            @endif

                            @if($profileAlumni->sekolah_smp)
                                <div class="mb-2 d-flex">
                                    <div class="fw-bold me-2" style="width: 180px;">SMP</div>
                                    <div>: {{ $profileAlumni->sekolah_smp }} (Lulus {{ $profileAlumni->tahun_lulus_smp ?? '-' }})</div>
                                </div>
                            @endif

                            @if($profileAlumni->sekolah_smk)
                                <div class="mb-2 d-flex">
                                    <div class="fw-bold me-2" style="width: 180px;">SMA/SMK</div>
                                    <div>: {{ $profileAlumni->sekolah_smk }} (Lulus {{ $profileAlumni->tahun_lulus ?? '-' }})</div>
                                </div>
                            @endif

                            @if($profileAlumni->universitas)
                                <div class="mb-2 d-flex">
                                    <div class="fw-bold me-2" style="width: 180px;">Universitas</div>
                                    <div>: {{ $profileAlumni->universitas }} (Lulus {{ $profileAlumni->tahun_lulus_universitas ?? '-' }})</div>
                                </div>
                            @endif

                            @if(empty($profileAlumni->sekolah_sd) && empty($profileAlumni->sekolah_smp) && empty($profileAlumni->sekolah_sma) && empty($profileAlumni->universitas))
                                <p class="text-muted">Data pendidikan belum tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Pengalaman Kerja Tab -->
                <div class="tab-pane fade" id="pengalaman" role="tabpanel" aria-labelledby="pengalaman-tab">
                    <div class="card mb-3">
                        <div class="card-body">

                            <!-- Tombol Tambah Pengalaman Kerja -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#pengalamanModal">
                                Tambah Pengalaman Kerja
                            </button>
                            <div class="card mb-3">
                                <div class="card-body">
                                    @forelse($profileAlumni->pengalamanKerja ?? [] as $pengalaman)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p><strong>Perusahaan:</strong> {{ $pengalaman->nama_perusahaan }}</p>
                                                <p><strong>Posisi:</strong> {{ $pengalaman->nama_pekerjaan }}</p>
                                                <p><strong>Durasi:</strong> {{ $pengalaman->tahun_awal }} - {{ $pengalaman->tahun_akhir }}</p>
                                            </div>
                                            
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('alumni.pengalamanKerja.hapus', $pengalaman->id_pengalaman_kerja) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengalaman kerja ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i></button>
                                            </form>
                                        </div>
                                        
                                        <hr>
                                    @empty
                                        <p>Tidak ada pengalaman kerja yang tersedia.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sertifikat Tab -->
                <div class="tab-pane fade" id="sertifikat" role="tabpanel" aria-labelledby="sertifikat-tab">
                    <div class="card mb-3">
                        <div class="card-body">
                            @forelse ($profileAlumni->sertifikat ?? [] as $sertifikat)
                                <p><strong>Nama Sertifikat:</strong> {{ $sertifikat->nama_sertifikat }}</p>
                                <p><strong>Tanggal Diterbitkan:</strong> {{ $sertifikat->tanggal_diterbitkan }}</p>
                                <hr>
                            @empty
                                <p>Tidak ada sertifikat yang tersedia.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Menambah Pengalaman Kerja -->
<div class="modal fade" id="pengalamanModal" tabindex="-1" aria-labelledby="pengalamanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pengalamanModalLabel">Tambah Pengalaman Kerja</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('alumni.tambahPengalaman') }}" method="POST">
              @csrf
              <div class="mb-3">
                  <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                  <input type="text" class="form-control" name="nama_pekerjaan" required>
              </div>
              <div class="mb-3">
                  <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                  <input type="text" class="form-control" name="nama_perusahaan" required>
              </div>
              <div class="mb-3">
                  <label for="tahun_awal" class="form-label">Tahun Awal</label>
                  <input type="number" class="form-control" name="tahun_awal" required>
              </div>
              <div class="mb-3">
                  <label for="tahun_akhir" class="form-label">Tahun Akhir</label>
                  <input type="number" class="form-control" name="tahun_akhir" required>
              </div>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Optional: kalau kamu mau tab aktif tetap tersimpan saat reload (pakai hash #)
        const triggerTabList = document.querySelectorAll('#profileTab a');
        triggerTabList.forEach(function (triggerEl) {
            const tabTrigger = new bootstrap.Tab(triggerEl);

            triggerEl.addEventListener('click', function (e) {
                e.preventDefault();
                tabTrigger.show();

                // Simpan tab aktif ke hash
                history.pushState(null, null, triggerEl.getAttribute('href'));
            });
        });

        // Saat halaman di-reload, aktifkan tab sesuai hash
        const hash = window.location.hash;
        if (hash) {
            const tabEl = document.querySelector('#profileTab a[href="' + hash + '"]');
            if (tabEl) {
                new bootstrap.Tab(tabEl).show();
            }
        }
    });
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,            
            showConfirmButton: false
        });
    @endif
</script>
@endpush


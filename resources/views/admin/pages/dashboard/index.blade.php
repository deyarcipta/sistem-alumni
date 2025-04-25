@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
@php
    use \App\Models\Admin;
    $user = auth('admin')->user();
    $roleNames = [
        Admin::ROLE_SUPER    => 'Admin',
        Admin::ROLE_KEPSEK   => 'Kepala Sekolah',
        Admin::ROLE_TU       => 'Tata Usaha',
        Admin::ROLE_KEUANGAN => 'Keuangan',
        Admin::ROLE_BKK      => 'BKK',
    ];
    $displayRole = $roleNames[$user->role] ?? ucfirst($user->role);
@endphp

<h1 class="h3 mb-4 text-gray-800">Dashboard {{$displayRole}}</h1>
<!-- Content Row -->
<div class="row">

  <!-- Jumlah Alumni -->
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Jumlah Alumni</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlahAlumni}}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Jumlah Alumni Bekerja -->
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Jumlah Alumni Bekerja</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$bekerja}}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Jumlah Alumni Berwirausaha -->
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Jumlah Alumni Berwirausaha</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$wirausaha}}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fas fa-store fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Jumlah Loker -->
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Jumlah Tracer Study</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlahTracerStudy}}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Presentase Pengisian Tracer</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="pieChartPresentaseAlumni"></canvas>
            </div>
            <div class="mt-4 text-center small">
                <span class="mr-3">
                    <i class="fas fa-circle text-success"></i> Sudah Mengisi
                </span>
                <span class="mr-3">
                    <i class="fas fa-circle text-warning"></i> Belum Mengisi
                </span>
            </div>
        </div>
    </div>
  </div>
  <!-- Card Tabel Legalisir Ijazah -->
<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengajuan Legalisir Ijazah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Alumni</th>
                            {{-- <th>Email</th> --}}
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($legalisirIjazah as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->alumni->nama }}</td> <!-- Menampilkan nama alumni -->
                            {{-- <td>{{ $item->email }}</td> --}}
                            <td>{{ $item->telepon }}</td>
                            <td>
                                @if($item->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($item->status == 'proses')
                                    <span class="badge badge-info">Proses</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetail{{ $item->id }}">Lihat</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal Detail Legalisir Ijazah -->
@foreach($legalisirIjazah as $item)
<div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Pengajuan Legalisir Ijazah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <strong>Nama Alumni:</strong> {{ $item->alumni->nama }} <br>
                        <strong>Email:</strong> {{ $item->email }} <br>
                        <strong>Telepon:</strong> {{ $item->telepon }} <br>
                        <strong>Alamat:</strong> {{ $item->nama_jalan }} <br>
                        <strong>RT/RW:</strong> {{ $item->rt }}/{{ $item->rw }} <br>
                        <strong>Nomor Rumah:</strong> {{ $item->nomor_rumah }} <br>
                        <strong>Kode Pos:</strong> {{ $item->kode_pos }} <br>
                    </div>
                    <div class="col-6">
                        <strong>Status Pengajuan:</strong> {{ ucfirst($item->status) }} <br>
                        <strong>Status Pembayaran:</strong> {{ ucfirst($item->status_pembayaran) }} <br>
                        <strong>Jasa Kirim:</strong> {{ $item->jasa_kirim }} <br>
                        <strong>Biaya Pengiriman:</strong> {{ $item->biaya_pengiriman ? 'Rp. ' . number_format($item->biaya_pengiriman, 0, ',', '.') : 'Tidak ada biaya' }} <br>
                        @if($item->bukti_pembayaran)
                            <strong>Bukti Pembayaran:</strong> <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a> <br>
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <strong>Provinsi:</strong> {{ $item->provinsi->nama }} <br> <!-- Nama Provinsi -->
                        <strong>Kota:</strong> {{ $item->kota->nama }} <br> <!-- Nama Kota -->
                    </div>
                    <div class="col-6">
                        <strong>Kecamatan:</strong> {{ $item->kecamatan->nama }} <br> <!-- Nama Kecamatan -->
                        <strong>Kelurahan:</strong> {{ $item->kelurahan->nama }} <br> <!-- Nama Kelurahan -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("pieChartPresentaseAlumni").getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Sudah Mengisi", "Belum Mengisi"], 
                datasets: [{
                    data: [{{ $sudahMengisi }}, {{ $belumMengisi }}],
                    backgroundColor: ['#1cc88a', '#f6c23e'],
                    hoverBackgroundColor: ['#17a673', '#f8c74a'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
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
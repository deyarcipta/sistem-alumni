@extends('alumni.layouts.app')
@section('title', 'Dashboard Alumni')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard Alumni</h1>
</div>
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
                          Jumlah Loker</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlahLoker}}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- Content Row -->
<div class="row">
  <!-- Content Column -->
  <div class="col-lg-8 mb-6">
    <!-- Pengisian Tracer Study -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pengisian Tracer Study</h6>
      </div>

      <div class="card-body">

        <!-- Progress Title -->
        <h6 class="mb-2 font-weight-bold text-dark">Progress Pengisian Tracer Study</h6>

        <!-- Progress Bar -->
        <div class="progress mb-4" style="height: 20px; border-radius: 10px;">
          <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%;"
              aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
              {{ $progress }}%
          </div>
        </div>

        <!-- Step Buttons -->
        <div class="row text-center">

          <div class="col-6 col-md-3 mb-2 d-flex">
            <a href="{{ route('alumni.tracer_study.step1') }}" class="d-block w-100 text-white bg-primary p-3" style="border-radius: 15px; height: 100%;">
              <strong>STEP 1:</strong><br>Verifikasi Data
            </a>
          </div>

          <div class="col-6 col-md-3 mb-2 d-flex">
            @if($tracerStudy)
              <a href="{{ route('alumni.tracer_study.step2', ['id' => $tracerStudy->id]) }}" class="d-block w-100 text-white bg-success p-3" style="border-radius: 15px; height: 100%;">
                <strong>STEP 2:</strong><br>Kuisioner Sekolah
              </a>
            @else
              <a href="#" data-bs-toggle="modal" data-bs-target="#modalTracerStudy" class="d-block w-100 text-white bg-secondary p-3" style="border-radius: 15px; height: 100%;">
                <strong>STEP 2:</strong><br>Kuisioner Sekolah
              </a>
            @endif
          </div>
          
          <div class="col-6 col-md-3 mb-2 d-flex">
            @if($tracerStudy)
              <a href="{{ route('alumni.tracer_study.step3', ['id' => $tracerStudy->id]) }}" class="d-block w-100 text-white bg-warning p-3" style="border-radius: 15px; height: 100%;">
                <strong>STEP 3:</strong><br>Kuisioner Dunia Kerja
              </a>
            @else
              <a href="#" data-bs-toggle="modal" data-bs-target="#modalTracerStudy" class="d-block w-100 text-white bg-secondary p-3" style="border-radius: 15px; height: 100%;">
                <strong>STEP 3:</strong><br>Kuisioner Dunia Kerja
              </a>
            @endif
          </div>
          
          <div class="col-6 col-md-3 mb-2 d-flex">
            @if($tracerStudy)
              <a href="{{ route('alumni.tracer_study.step4', ['id' => $tracerStudy->id]) }}" class="d-block w-100 text-white bg-info p-3" style="border-radius: 15px; height: 100%;">
                <strong>STEP 4:</strong><br>Data Diri
              </a>
            @else
              <a href="#" data-bs-toggle="modal" data-bs-target="#modalTracerStudy" class="d-block w-100 text-white bg-secondary p-3" style="border-radius: 15px; height: 100%;">
                <strong>STEP 4:</strong><br>Data Diri
              </a>
            @endif
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
            <h6 class="m-0 font-weight-bold text-primary">Presentase Alumni</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="pieChartPresentaseAlumni"></canvas>
            </div>
            <div class="mt-4 text-center small">
                <span class="mr-3">
                    <i class="fas fa-circle text-success"></i> Bekerja
                </span>
                <span class="mr-3">
                    <i class="fas fa-circle text-info"></i> Wirausaha
                </span>
                <span class="mr-3">
                    <i class="fas fa-circle text-primary"></i> Belum Bekerja
                </span>
                <span class="mr-3">
                    <i class="fas fa-circle text-warning"></i> Belum Mengisi
                </span>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- Modal Alert -->
<div class="modal fade" id="modalTracerStudy" tabindex="-1" aria-labelledby="modalTracerStudyLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTracerStudyLabel">Peringatan</h5>
      </div>
      <div class="modal-body">
        Silakan isi Verifikasi Data terlebih dahulu sebelum melanjutkan ke kuisioner lainnya.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("pieChartPresentaseAlumni").getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Bekerja", "Wirausaha", "Belum Bekerja","Belum Mengisi"],
            datasets: [{
                data: [{{ $bekerja }}, {{ $wirausaha }}, {{ $belumBekerja }}, {{$jumlahBelumMengisi}}],
                backgroundColor: ['#1cc88a', '#36b9cc', '#4e73df', '#f6c23e'],
                hoverBackgroundColor: ['#17a673', '#2c9faf', '#2e59d9', '#f8c74a'],
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
</script>
@endpush

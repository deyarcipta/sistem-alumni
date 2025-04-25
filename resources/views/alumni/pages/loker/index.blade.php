@extends('alumni.layouts.app')
@section('title', 'Lowongan Kerja')

@section('content')
<div class="container">
    <h3 class="mb-4">Lowongan Kerja</h3>

    <div class="card">
        <div class="card-header">Daftar Lowongan</div>
        <div class="card-body">
            <table id="lowonganTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Loker</th>
                        <th>Perusahaan</th>
                        <th>Periode</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loker as $loker)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $loker->judul_loker }}</td>
                            <td>{{ $loker->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td>{{ $loker->tanggal_mulai }} s/d {{ $loker->tanggal_berakhir }}</td>
                            <td>{{ $loker->lokasi }}</td>
                            <td>
                                <!-- Tombol untuk melihat detail loker menggunakan modal -->
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#lokerModal{{ $loker->id }}">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>

                                <!-- Modal untuk detail loker -->
                                <div class="modal fade" id="lokerModal{{ $loker->id }}" tabindex="-1" role="dialog" aria-labelledby="lokerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="lokerModalLabel">Detail Lowongan: {{ $loker->judul_loker }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Perusahaan:</strong> {{ $loker->perusahaan->nama_perusahaan ?? '-' }}</p>
                                                <p><strong>Periode:</strong> {{ $loker->tanggal_mulai }} s/d {{ $loker->tanggal_berakhir }}</p>
                                                <p><strong>Lokasi:</strong> {{ $loker->lokasi }}</p>
                                                <p><strong>Deskripsi:</strong> {{ $loker->deskripsi }}</p>

                                                @if($loker->foto)
                                                    <p><strong>Foto Lowongan:</strong></p>
                                                    <img src="{{ asset('storage/loker/' . $loker->foto) }}" alt="Foto Lowongan" class="img-fluid">
                                                @else
                                                    <p><strong>Foto Lowongan:</strong> Tidak tersedia</p>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                                                <!-- Button Hubungi BKK -->
                                                <a href="https://wa.me/{{$setting->no_wa_bkk}}?text=Halo%2C%20Nama%20saya%20{{ urlencode($alumni->nama) }}%20lulusan%20tahun%20{{ urlencode($alumni->tahun_lulus) }}%2C%20saya%20dari%20jurusan%20{{ urlencode($alumni->jurusan->nama_jurusan) }}%2C%20saya%20ingin%20melamar%20lowongan%20{{ urlencode($loker->judul_loker) }}%20yang%20ditawarkan%20oleh%20{{ urlencode($loker->perusahaan->nama_perusahaan) }}."
                                                   target="_blank" class="btn btn-success">
                                                    <i class="fab fa-whatsapp"></i> Hubungi BKK
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada lowongan kerja saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#lowonganTable').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Tidak ditemukan dokumen",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ dokumen",
                "infoEmpty": "Tidak ada data",
                "infoFiltered": "(difilter dari _MAX_ total dokumen)",
            }
        });
    });
</script>
@endpush

@extends('alumni.layouts.app')
@section('title', 'Dokumen Alumni')

@section('content')
<div class="container">
    <h3 class="mb-4">Dokumen Alumni</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel Dokumen -->
    <div class="card">
        <div class="card-header">Unduh Dokumen</div>
        <div class="card-body">
            <table id="dokumenTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dokumen as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jenis_dokumen }}</td>
                            <td>
                                @if ($tagihan && in_array($tagihan->status, ['belum_bayar', 'proses']))
                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#tagihanModal">
                                        Bayar Tagihan untuk Mengunduh
                                    </button>
                                @else
                                    <a href="{{ route('alumni.dokumen.download', $item->id_dokumen) }}" class="btn btn-sm btn-success">
                                        Download
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada dokumen</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Peringatan Tagihan -->
<div class="modal fade" id="tagihanModal" tabindex="-1" role="dialog" aria-labelledby="tagihanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tagihanModalLabel">Peringatan Tagihan</h5>
            </div>
            <div class="modal-body">
                @if ($tagihan)
                    Anda memiliki tagihan yang belum dibayar sebesar 
                    <strong>Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</strong>.
                    Silakan selesaikan pembayaran untuk dapat mengunduh dokumen ini.
                @else
                    Tidak ada tagihan yang belum dibayar.
                @endif
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="{{ route('alumni.tagihan.index') }}">bayar Tagihan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                {{-- <a href="{{ route('alumni.tagihan.index') }}" class="btn btn-primary">Bayar Sekarang</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let jumlahData = {{ $dokumen->count() }};
        if (jumlahData > 0) {
            $('#dokumenTable').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Tidak ditemukan dokumen",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ dokumen",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(difilter dari _MAX_ total dokumen)",
                    "emptyTable": "Tidak ada data dokumen untuk ditampilkan"
                }
            });
        }
    });
</script>
@endpush


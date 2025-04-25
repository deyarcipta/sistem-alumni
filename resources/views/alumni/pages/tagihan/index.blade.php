@extends('alumni.layouts.app')
@section('title', 'Tagihan Alumni')
@section('content')
<div class="container">
    <h3 class="mb-4">Tagihan Alumni</h3>

    <div class="card">
        <div class="card-header">Daftar Tagihan</div>
        <div class="card-body">
            <table id="tagihanTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tagihan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tagihan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>Tagihan Sekolah</td>
                            <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusText = str_replace('_', ' ', ucwords($item->status, '_'));
                                    switch ($item->status) {
                                        case 'belum_bayar':
                                            $badgeClass = 'badge-danger';
                                            break;
                                        case 'proses':
                                            $badgeClass = 'badge-warning';
                                            break;
                                        case 'sudah_dibayar':
                                            $badgeClass = 'badge-success';
                                            break;
                                        default:
                                            $badgeClass = 'badge-secondary';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                @if ($item->bukti_pembayaran)
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#lihatModal{{ $item->id_tagihan }}">
                                        Lihat Bukti
                                    </button>
                                @elseif ($item->status === 'belum_bayar')
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#bayarModal{{ $item->id_tagihan }}">
                                        Bayar Tagihan
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Upload Bukti -->
                        <div class="modal fade" id="bayarModal{{ $item->id_tagihan }}" tabindex="-1" role="dialog" aria-labelledby="bayarModalLabel{{ $item->id_tagihan }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="{{ route('alumni.tagihan.bayar', $item->id_tagihan) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="bayarModalLabel{{ $item->id_tagihan }}">Bayar Tagihan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Unggah bukti pembayaran untuk tagihan <strong>{{ $item->nama_tagihan }}</strong> sebesar <strong>Rp {{ number_format($item->nominal,0,',','.') }}</strong>.</p>
                                            <p><strong>Silakan transfer ke rekening berikut:</strong></p>
                                            <ul>
                                                <li>Bank: {{ $setting->bank }}</li>
                                                <li>Nomor Rekening: <strong>{{ $setting->nomor_rekening }}</strong></li>
                                                <li>Atas Nama: <strong>{{ $setting->atas_nama }}</strong></li>
                                            </ul>
                                            <hr>
                                            <div class="form-group">
                                                <label for="bukti">Pilih file (jpg, png, pdf) maksimal 2MB</label>
                                                <input type="file" name="bukti" id="bukti" class="form-control @error('bukti') is-invalid @enderror" required>
                                                @error('bukti')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Upload Bukti</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Lihat Bukti -->
                        @if ($item->bukti_pembayaran)
                        <div class="modal fade" id="lihatModal{{ $item->id_tagihan }}" tabindex="-1" role="dialog" aria-labelledby="lihatModalLabel{{ $item->id_tagihan }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="lihatModalLabel{{ $item->id_tagihan }}">Bukti Pembayaran</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        @php
                                            $ext = pathinfo($item->bukti_pembayaran, PATHINFO_EXTENSION);
                                        @endphp
                                        @if (in_array(strtolower($ext), ['jpg','jpeg','png']))
                                            <img src="{{ Storage::url('bukti_tagihan/'.$item->bukti_pembayaran) }}" class="img-fluid" alt="Bukti Pembayaran">
                                        @else
                                            <embed src="{{ Storage::url('bukti_tagihan/'.$item->bukti_pembayaran) }}" type="application/pdf" width="100%" height="600px" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada tagihan.</td>
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
        let rowCount = $('#tagihanTable tbody tr').not(':has(td[colspan])').length;
        if (rowCount > 0) {
            $('#tagihanTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    zeroRecords: "Tidak ditemukan tagihan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ tagihan",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(difilter dari _MAX_ total tagihan)",
                    emptyTable: "Tidak ada data tagihan untuk ditampilkan"
                }
            });
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

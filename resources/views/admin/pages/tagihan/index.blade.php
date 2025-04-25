@extends('admin.layouts.app')
@section('title', 'Data Tagihan Alumni')
@section('content')
<div class="container">
    <h3 class="mb-4">Data Tagihan Alumni</h3>

    {{-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <div class="card mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4 card-header">
            Daftar Tagihan
            <div>
                <button class="btn btn-primary me-2" data-toggle="modal" data-target="#modalImportTagihan">
                    <i class="fas fa-file-import"></i> Import Tagihan
                </button>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalTambahTagihan">
                    Tambah Tagihan
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped" id="tagihanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $i => $t)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $t->alumni->nama }}</td>
                            <td>Rp {{ number_format($t->nominal,0,',','.') }}</td>
                            <td>
                                @php
                                    $statusText = str_replace('_', ' ', ucwords($t->status, '_'));
                                    switch ($t->status) {
                                        case 'belum_bayar':
                                            $badgeClass = 'badge badge-danger';
                                            break;
                                        case 'proses':
                                            $badgeClass = 'badge badge-warning';
                                            break;
                                        case 'sudah_dibayar':
                                            $badgeClass = 'badge badge-success';
                                            break;
                                        default:
                                            $badgeClass = 'badge badge-secondary';
                                    }
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                @if($t->bukti_pembayaran)
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#lihatAdmin{{ $t->id_tagihan }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endif
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit{{ $t->id_tagihan }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus{{ $t->id_tagihan }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        @if($t->bukti_pembayaran)
                        <div class="modal fade" id="lihatAdmin{{ $t->id_tagihan }}" tabindex="-1" role="dialog" aria-labelledby="lihatAdminLabel{{ $t->id_tagihan }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tagihan.verify', $t->id_tagihan) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="lihatAdminLabel{{ $t->id_tagihan }}">Bukti Pembayaran - {{ $t->alumni->nama }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            @php $ext = pathinfo($t->bukti_pembayaran, PATHINFO_EXTENSION); @endphp
                                            @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                                <img src="{{ Storage::url('bukti_tagihan/'.$t->bukti_pembayaran) }}" class="img-fluid" alt="Bukti Pembayaran">
                                            @else
                                                <embed src="{{ Storage::url('bukti_tagihan/'.$t->bukti_pembayaran) }}" type="application/pdf" width="100%" height="600px" />
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Verifikasi</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </tbody>
            </table>

            {{-- Modals Edit & Hapus --}}
            @foreach($tagihan as $t)
            {{-- Modal Edit --}}
            <div class="modal fade" id="modalEdit{{ $t->id_tagihan }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.tagihan.update', $t->id_tagihan) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Tagihan: {{ $t->alumni->nama }}</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label>Alumni</label>
                                    <select name="id_alumni" class="form-control" required>
                                        @foreach($alumniList as $a)
                                            <option value="{{ $a->id_alumni }}" {{ $t->id_alumni == $a->id_alumni ? 'selected' : '' }}>{{ $a->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Nominal (Rp)</label>
                                    <input type="number" name="nominal" class="form-control" value="{{ $t->nominal }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="belum_bayar" {{ $t->status=='belum_bayar' ? 'selected':'' }}>Belum Bayar</option>
                                        <option value="sudah_bayar" {{ $t->status=='sudah_bayar' ? 'selected':'' }}>Sudah Bayar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Hapus --}}
            <div class="modal fade" id="modalHapus{{ $t->id_tagihan }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            Hapus tagihan untuk <strong>{{ $t->alumni->nama }}</strong> sebesar <strong>Rp {{ number_format($t->nominal,0,',','.') }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('admin.tagihan.destroy', $t->id_tagihan) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Modal Tambah Tagihan -->
<div class="modal fade" id="modalTambahTagihan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tagihan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tagihan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Alumni</label>
                        <select name="id_alumni" class="form-control" required>
                            <option value="">-- Pilih Alumni --</option>
                            @foreach($alumniList as $a)
                                <option value="{{ $a->id_alumni }}">{{ $a->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nominal (Rp)</label>
                        <input type="number" name="nominal" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="belum_bayar">Belum Bayar</option>
                            <option value="sudah_bayar">Sudah Bayar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Tagihan -->
<div class="modal fade" id="modalImportTagihan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tagihan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Tagihan</h5>
                    <a href="{{ asset('storage/template/template_import_tagihan.xlsx') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-download"></i> Download Template
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih File CSV</label>
                        <input type="file" name="file" class="form-control" accept=".csv" required>
                    </div>
                    <div class="alert alert-info mt-2">
                        <strong>Petunjuk:</strong><br>
                        Sebelum melakukan import file, pastikan file yang diimport menggunakan template yang sudah diunduh pada tombol di atas.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
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
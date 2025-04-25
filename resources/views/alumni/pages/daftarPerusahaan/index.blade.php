@extends('alumni.layouts.app')
@section('title', 'Data Perusahaan')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Perusahaan</h3>

    <div class="card">
        <div class="card-header">Data Perusahaan</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Perusahaan</th>
                        <th>Bidang</th>
                        <th>Alamat</th>
                        {{-- <th>Telepon</th> --}}
                        <th>Website</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perusahaan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ asset('storage/daftar_perusahaan/' . $item->foto_perusahaan) }}" alt="Logo" width="50"></td>
                            <td>{{ $item->nama_perusahaan }}</td>
                            <td>{{ $item->bidang_perusahaan ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            {{-- <td>{{ $item->telepon ?? '-' }}</td> --}}
                            <td>
                                @if ($item->website)
                                    <a href="{{ $item->website }}" target="_blank">{{ $item->website }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data perusahaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

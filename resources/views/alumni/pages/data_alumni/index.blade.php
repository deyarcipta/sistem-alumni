@extends('alumni.layouts.app')
@section('title', 'Data Alumni')
@section('content')
<div class="container">
    <h3 class="mb-4">Data Alumni</h3>

    <!-- Form untuk memilih tahun lulus -->
    <form action="{{ route('alumni.alumni.index') }}" method="GET">
        <div class="row">
            <div class="col-md-4">
                <label for="tahun_lulus">Tahun Lulus</label>
                <select name="tahun_lulus" id="tahun_lulus" class="form-control" onchange="this.form.submit()">
                    @foreach ($tahunLulusOptions as $tahun)
                        <option value="{{ $tahun }}" {{ $tahun == $tahunLulus ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="card mt-4">
        <div class="card-header">Data Alumni Tahun Lulus {{ $tahunLulus }}</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>Jurusan</th>
                        <th>Tahun Lulus</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alumni as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jurusan->nama_jurusan ?? 'N/A' }}</td> <!-- Asumsi ada relasi dengan tabel jurusan -->
                            <td>{{ $item->tahun_lulus }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Tidak ada data alumni untuk tahun ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

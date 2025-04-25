@extends('alumni.layouts.app')
@section('title', 'Buku Wisuda')

@section('content')
<div class="container">
    <h4 class="mb-4">Buku Wisuda</h4>

    @if ($bukuWisuda->isEmpty())
        <div class="alert alert-info">Belum ada buku wisuda untuk tahun {{ $tahunLulus }}.</div>
    @else
        <div class="row">
            @foreach ($bukuWisuda as $buku)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">{{ $buku->judul }}</div>
                        <div class="card-body">
                            <p>{{ $buku->deskripsi }}</p>
                            <a href="{{ asset('storage/buku_wisuda/' . $buku->file) }}" target="_blank" class="btn btn-primary btn-sm">
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

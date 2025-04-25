@extends('alumni.layouts.app')
@section('title', 'Form Tracer Study - Step 2')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Form Tracer Study - Step 2</h1>

    <form method="POST" action="{{ route('alumni.tracer_study.storeStep2', ['id' => optional($tracerStudy)->id]) }}">
        @csrf

        <div class="card">
            <div class="card-header">
                Step 2 - Kuisioner Sekolah
            </div>
            <div class="card-body">

                @php
                    $options = [
                        1 => '1 - Sangat Baik',
                        2 => '2 - Baik',
                        3 => '3 - Cukup Baik',
                        4 => '4 - Kurang',
                        5 => '5 - Tidak sama sekali',
                    ];
                @endphp

                <div class="form-group">
                    <label for="pembelajaran">Bagaimana kualitas pembelajaran di sekolah?</label>
                    <select name="pembelajaran" id="pembelajaran" class="form-control">
                        <option value="">-</option>
                        @foreach($options as $key => $label)
                            <option value="{{ $key }}" {{ old('pembelajaran', optional($tracerStudy)->pembelajaran) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="praktek">Bagaimana pengalaman praktek di sekolah?</label>
                    <select name="praktek" id="praktek" class="form-control">
                        <option value="">-</option>
                        @foreach($options as $key => $label)
                            <option value="{{ $key }}" {{ old('praktek', optional($tracerStudy)->praktek) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="sarpras">Bagaimana sarana dan prasarana di sekolah?</label>
                    <select name="sarpras" id="sarpras" class="form-control">
                        <option value="">-</option>
                        @foreach($options as $key => $label)
                            <option value="{{ $key }}" {{ old('sarpras', optional($tracerStudy)->sarpras) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="pkl">Bagaimana pengalaman PKL di sekolah?</label>
                    <select name="pkl" id="pkl" class="form-control">
                        <option value="">-</option>
                        @foreach($options as $key => $label)
                            <option value="{{ $key }}" {{ old('pkl', optional($tracerStudy)->pkl) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="biaya">Bagaimana pengalaman terkait biaya di sekolah?</label>
                    <select name="biaya" id="biaya" class="form-control">
                        <option value="">-</option>
                        @foreach($options as $key => $label)
                            <option value="{{ $key }}" {{ old('biaya', optional($tracerStudy)->biaya) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan & Lanjutkan</button>
    </form>
</div>
@endsection

{{-- @push('scripts')

<script>
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

@endpush --}}

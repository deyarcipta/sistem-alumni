<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller; // <- ini benar
use Illuminate\Support\Facades\DB;
use App\Models\TracerStudy;
use App\Models\Alumni;
use App\Models\Loker;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();
        $nis = auth()->user()->nis;

        $jumlahAlumni = Alumni::count();
        $jumlahLoker = Loker::count();

        // Ambil data alumni berdasarkan NIS
        $alumni = Alumni::where('nis', $nis)->first();

        // Ambil data tracer study alumni
        $tracerStudy = TracerStudy::where('nis', $nis)->first();

        // Inisialisasi progress
        $filledSteps = 0;
        $progress = 0;

        // Hitung step progress hanya jika data tracerStudy ada
        if ($tracerStudy) {
            $step1 = $tracerStudy->nis && $tracerStudy->nisn && $tracerStudy->nama_siswa && $tracerStudy->jurusan && $tracerStudy->tahun_lulus && $tracerStudy->email && $tracerStudy->nomor_wa;
            $step2 = $tracerStudy->pembelajaran || $tracerStudy->praktek || $tracerStudy->sarpras || $tracerStudy->pkl || $tracerStudy->biaya;
            $step3 = $tracerStudy->mencari_pekerjaan || $tracerStudy->proses_mencari_kerja || $tracerStudy->jml_perusahaan || $tracerStudy->respon_perusahaan || $tracerStudy->undangan_perusahaan || $tracerStudy->status_kerja;
            $step4 = $tracerStudy->pekerjaan || $tracerStudy->perusahaan || $tracerStudy->posisi_pekerjaan || $tracerStudy->gaji;

            if ($step1) $filledSteps++;
            if ($step2) $filledSteps++;
            if ($step3) $filledSteps++;
            if ($step4) $filledSteps++;

            $progress = $filledSteps * 25;
        }

        // Data untuk Pie Chart
        $bekerja = TracerStudy::where('pekerjaan', '!=', null)
                            ->where('pekerjaan', '!=', 'Wirausaha')
                            ->count();
        $wirausaha = TracerStudy::where('pekerjaan', 'Wirausaha')->count();
        $belumBekerja = TracerStudy::whereNull('pekerjaan')->count();

        $jumlahBelumMengisi = DB::table('alumni')
            ->leftJoin('tracer_studies', 'alumni.nis', '=', 'tracer_studies.nis')
            ->whereNull('tracer_studies.nis')
            ->count();

        return view('alumni.pages.dashboard.index', compact(
            'setting',
            'alumni',
            'jumlahAlumni',
            'jumlahLoker',
            'tracerStudy',
            'progress',
            'bekerja',
            'wirausaha',
            'belumBekerja',
            'jumlahBelumMengisi'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

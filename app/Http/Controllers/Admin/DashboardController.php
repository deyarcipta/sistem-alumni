<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <- ini benar
use App\Models\TracerStudy;
use App\Models\LegalisirIjazah;
use App\Models\Alumni;
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
        $jumlahAlumni = Alumni::count();
        $bekerja = TracerStudy::where('pekerjaan', '!=', null)
                                ->where('pekerjaan', '!=', 'Wirausaha')
                                ->count();
        $wirausaha = TracerStudy::where('pekerjaan', 'Wirausaha')->count();
        $belumBekerja = TracerStudy::whereNull('pekerjaan')->count();
        $jumlahTracerStudy = TracerStudy::count();

        // Alumni yang sudah mengisi tracer study berdasarkan nis (misalnya pekerjaan sudah terisi)
        $sudahMengisi = TracerStudy::whereNotNull('pekerjaan')
        ->whereIn('nis', Alumni::pluck('nis'))
        ->count();

        // Alumni yang belum mengisi tracer study berdasarkan nis (misalnya pekerjaan kosong)
        $tracerStudies = TracerStudy::with('alumni')->get();
        $alumniIdsWithTracer = $tracerStudies->pluck('nis')->toArray();
        $belumMengisi = Alumni::whereNotIn('nis', $alumniIdsWithTracer)->count();

        // Ambil data pengajuan legalisir ijazah dengan status 'pending' dan 'proses' diurutkan berdasarkan 'created_at'
        $legalisirIjazah = LegalisirIjazah::whereIn('status', ['pending', 'proses'])
                                      ->orderBy('created_at', 'desc')
                                      ->take(5)
                                      ->get();

        return view('admin.pages.dashboard.index', compact(
            'setting',
            'jumlahAlumni',
            'bekerja',
            'wirausaha',
            'belumBekerja',
            'jumlahTracerStudy',
            'sudahMengisi',
            'belumMengisi',
            'legalisirIjazah'
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

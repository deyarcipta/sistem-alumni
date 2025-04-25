<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TracerStudy;
use App\Models\Alumni;

class TracerStudyController extends Controller
{
    public function createStep1()
    {
        // Ambil data alumni berdasarkan NIS (misalnya dari auth user)
        $nis = auth()->user()->nis; // Sesuaikan sesuai dengan cara mendapatkan NIS

        // Ambil data alumni dari database
        $alumni = Alumni::where('nis', $nis)->first();

        // Cek apakah sudah ada tracer study untuk alumni ini
        $tracerStudy = TracerStudy::where('nis', $nis)->first();

        if ($tracerStudy) {
            return view('alumni.pages.tracer_study.create', compact('alumni', 'tracerStudy'));
        } else {
            return view('alumni.pages.tracer_study.create', compact('alumni'));
        }
    }

    public function storeStep1(Request $request)
    {
        // Validasi input step 1
        $request->validate([
            'email' => 'required|email|max:255',
            'nomor_wa' => 'required|string|max:255',
        ]);

        // Cek apakah sudah ada tracer study untuk alumni ini
        $tracerStudy = TracerStudy::updateOrCreate(
            ['nis' => $request->nis], // Mencocokkan berdasarkan NIS
            [
                'nisn' => $request->nisn,
                'nama_siswa' => $request->nama_siswa,
                'jurusan' => $request->jurusan,
                'tahun_lulus' => $request->tahun_lulus,
                'email' => $request->email,
                'nomor_wa' => $request->nomor_wa,
            ]
        );

        return redirect()->route('alumni.tracer_study.step2', ['id' => $tracerStudy->id]);
    }

    public function createStep2($id)
    {
        // Ambil data tracerStudy yang sudah disimpan
        $tracerStudy = TracerStudy::findOrFail($id);

        return view('alumni.pages.tracer_study.step2', compact('tracerStudy'));
    }

    public function storeStep2(Request $request, $id)
    {
        // Validasi input step 2
        $request->validate([
            'pembelajaran' => 'nullable|string',
            'praktek' => 'nullable|string',
            'sarpras' => 'nullable|string',
            'pkl' => 'nullable|string',
            'biaya' => 'nullable|string',
        ]);

        // Update data step 2
        $tracerStudy = TracerStudy::findOrFail($id);
        $tracerStudy->update($request->only([
            'pembelajaran',
            'praktek',
            'sarpras',
            'pkl',
            'biaya',
        ]));

        return redirect()->route('alumni.tracer_study.step3', ['id' => $tracerStudy->id]);
    }

    public function createStep3($id)
    {
        // Ambil data tracerStudy yang sudah disimpan sampai step 2
        $tracerStudy = TracerStudy::findOrFail($id);

        return view('alumni.pages.tracer_study.step3', compact('tracerStudy'));
    }

    public function storeStep3(Request $request, $id)
    {
        // Validasi input step 3
        $request->validate([
            'mencari_pekerjaan' => 'nullable|string',
            'proses_mencari_kerja' => 'nullable|string',
            'jml_perusahaan' => 'nullable|string',
            'respon_perusahaan' => 'nullable|string',
            'undangan_perusahaan' => 'nullable|string',
            'status_kerja' => 'nullable|string',
        ]);

        // Update data step 3
        $tracerStudy = TracerStudy::findOrFail($id);
        $tracerStudy->update($request->only([
            'mencari_pekerjaan',
            'proses_mencari_kerja',
            'jml_perusahaan',
            'respon_perusahaan',
            'undangan_perusahaan',
            'status_kerja',
        ]));

        return redirect()->route('alumni.tracer_study.step4', ['id' => $tracerStudy->id]);
    }

    public function createStep4($id)
    {
        // Ambil data tracerStudy yang sudah disimpan sampai step 3
        $tracerStudy = TracerStudy::findOrFail($id);

        return view('alumni.pages.tracer_study.step4', compact('tracerStudy'));
    }

    public function storeStep4(Request $request, $id)
    {
        // Validasi input step 4
        $request->validate([
            'status_pekerjaan_sebelum_lulus' => 'required|in:Iya,Tidak',
            'durasi_pekerjaan' => 'nullable|integer',
            'pekerjaan' => 'nullable|string',
            'perusahaan' => 'nullable|string',
            'posisi_pekerjaan' => 'nullable|string',
            'tahun_masuk_pekerjaan' => 'nullable|string',
            'gaji' => 'nullable|string',
            'etika' => 'nullable|integer',
            'bahasa_inggris' => 'nullable|integer',
            'komunikasi' => 'nullable|integer',
            'kerja_sama' => 'nullable|integer',
            'pengembangan_diri' => 'nullable|integer',
            'saran' => 'nullable|string',
        ]);
        // Update data step 4
        $tracerStudy = TracerStudy::findOrFail($id);
        $tracerStudy->update($request->all());

        return redirect()->route('alumni.tracer_study.step4', ['id' => $tracerStudy->id])->with('completed', true);
    }

}

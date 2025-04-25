<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TracerStudy;
use App\Models\Alumni;
use Illuminate\Http\Request;

class TracerStudyController extends Controller
{
    public function index()
    {
        $tracerStudies = TracerStudy::with('alumni')->get();
        $alumniIdsWithTracer = $tracerStudies->pluck('nis')->toArray();
        $alumniTanpaTracer = Alumni::whereNotIn('nis', $alumniIdsWithTracer)->get();

        return view('admin.pages.tracer_study.index', compact('tracerStudies', 'alumniTanpaTracer'));
    }

    public function destroy($id)
    {
        $tracer = TracerStudy::findOrFail($id);
        $tracer->delete();

        return redirect()->back()->with('success', 'Data Tracer Study berhasil dihapus.');
    }
}

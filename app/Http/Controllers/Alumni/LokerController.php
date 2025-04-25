<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loker;
use Illuminate\Support\Facades\Storage;

class LokerController extends Controller
{
    public function index()
    {
        $alumni = auth()->user();
        $loker = Loker::with('perusahaan')->get();
        return view('alumni.pages.loker.index', compact('alumni','loker'));
    }
}

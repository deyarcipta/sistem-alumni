<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/kota/{prov_id}', fn($id) => DB::table('kota')->where('provinsi_id', $id)->get());
Route::get('/kecamatan/{kota_id}', fn($id) => DB::table('kecamatan')->where('kota_id', $id)->get());
Route::get('/kelurahan/{kec_id}', fn($id) => DB::table('kelurahan')->where('kecamatan_id', $id)->get());

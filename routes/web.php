<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as ProfileAdminController;
use App\Http\Controllers\Admin\JurusanController as JurusanAdminController;
use App\Http\Controllers\Admin\DataAlumniController as DataAlumniController;
use App\Http\Controllers\Admin\IjazahController as IjazahAdminController;
use App\Http\Controllers\Admin\SertifikatController as SertifikatAdminController;
use App\Http\Controllers\Admin\DokumenController as DokumenAdminController;
use App\Http\Controllers\Admin\TagihanController as TagihanAdminController;
use App\Http\Controllers\Admin\TracerStudyController as TracerStudyAdminController;
use App\Http\Controllers\Admin\LegalisirIjazahController as LegalisirIjazahAdminController;
use App\Http\Controllers\Admin\BukuWisudaController as BukuWisudaAdminController;
use App\Http\Controllers\Admin\LokerController as LokerAdminController;
use App\Http\Controllers\Admin\PerusahaanController as PerusahaanAdminController;
use App\Http\Controllers\Admin\UserController as UserAdminController;
use App\Http\Controllers\Admin\SettingController as SettingAdminController;

use App\Http\Controllers\Alumni\AuthController as AlumniAuth;
use App\Http\Controllers\Alumni\DashboardController as AlumniDashboardController;
use App\Http\Controllers\Alumni\DokumenAlumniController as DokumenAlumniController;
use App\Http\Controllers\Alumni\SertifikatAlumniController as SertifikatAlumniController;
use App\Http\Controllers\Alumni\TagihanAlumniController as TagihanAlumniController;
use App\Http\Controllers\Alumni\BukuWisudaController as BukuWisudaController;
use App\Http\Controllers\Alumni\AlumniController as AlumniController;
use App\Http\Controllers\Alumni\ProfileAlumniController as ProfileAlumniController;
use App\Http\Controllers\Alumni\TracerStudyController as TracerStudyController;
use App\Http\Controllers\Alumni\LegalisirIjazahController as LegalisirIjazahController;
use App\Http\Controllers\Alumni\DaftarPerusahaanController as DaftarPerusahaanController;
use App\Http\Controllers\Alumni\LokerController as LokerController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuth::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuth::class, 'login']);
    Route::post('logout', [AdminAuth::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard.index');

        // Route Import Data Master
        Route::get('/data-alumni/import', [DataAlumniController::class, 'showImportForm'])->name('data-alumni.import.form');
        Route::post('/data-alumni/import', [DataAlumniController::class, 'import'])->name('data-alumni.import');

        // Route Profile Admin
        Route::get('profile', [ProfileAdminController::class, 'show'])->name('profile');
        Route::put('update-foto/{id}', [ProfileAdminController::class, 'updateFoto'])->name('updateFoto');
        Route::put('/update-profile/{id}', [ProfileAdminController::class, 'updateProfile'])->name('updateProfile');


        // Route Jurusan
        Route::get('/jurusan', [JurusanAdminController::class, 'index'])->name('jurusan.index');
        Route::post('/jurusan', [JurusanAdminController::class, 'store'])->name('jurusan.store');
        Route::put('/jurusan/{id}', [JurusanAdminController::class, 'update'])->name('jurusan.update');
        Route::delete('/jurusan/{id}', [JurusanAdminController::class, 'destroy'])->name('jurusan.destroy');
        Route::post('/jurusan/import', [JurusanAdminController::class, 'import'])->name('jurusan.import');

        // Route Data Alumni
        Route::resource('alumni', DataAlumniController::class);
        Route::post('/alumni', [DataAlumniController::class, 'store'])->name('alumni.store');
        Route::put('alumni/{alumnus}', [DataAlumniController::class, 'update'])->name('alumni.update');
        Route::put('/alumni/reset-password/{id}', [DataAlumniController::class, 'resetPassword'])->name('alumni.resetPassword');

        // Route Ijazah
        Route::get('ijazah', [IjazahAdminController::class, 'index'])->name('ijazah.index');
        Route::post('ijazah', [IjazahAdminController::class, 'store'])->name('ijazah.store');
        Route::put('ijazah/{id}', [IjazahAdminController::class, 'update'])->name('ijazah.update');
        Route::delete('ijazah/{id}', [IjazahAdminController::class, 'destroy'])->name('ijazah.destroy');
        Route::post('ijazah/import', [IjazahAdminController::class, 'import'])->name('ijazah.import');
        Route::post('ijazah/upload-zip', [IjazahAdminController::class, 'uploadZip'])->name('ijazah.upload.zip');


        // Route Sertifikat
        Route::get('sertifikat', [SertifikatAdminController::class, 'index'])->name('sertifikat.index');
        Route::post('sertifikat', [SertifikatAdminController::class, 'store'])->name('sertifikat.store');
        Route::put('sertifikat/{id}', [SertifikatAdminController::class, 'update'])->name('sertifikat.update');
        Route::delete('sertifikat/{id}', [SertifikatAdminController::class, 'destroy'])->name('sertifikat.destroy');
        Route::post('sertifikat/import', [SertifikatAdminController::class, 'import'])->name('sertifikat.import');
        Route::post('sertifikat/upload-zip', [SertifikatAdminController::class, 'uploadZip'])->name('sertifikat.upload.zip');

        // Route Dokumen All
        Route::get('dokumen', [DokumenAdminController::class, 'index'])->name('dokumen.index');
        Route::post('dokumen', [DokumenAdminController::class, 'store'])->name('dokumen.store');
        Route::put('dokumen/{id}', [DokumenAdminController::class, 'update'])->name('dokumen.update');
        Route::delete('dokumen/{id}', [DokumenAdminController::class, 'destroy'])->name('dokumen.destroy');
        Route::post('dokumen/import', [DokumenAdminController::class, 'import'])->name('dokumen.import');
        Route::post('dokumen/upload-zip', [DokumenAdminController::class, 'uploadZip'])->name('dokumen.upload.zip');

        // Route Tagihan
        Route::get('tagihan', [TagihanAdminController::class, 'index'])->name('tagihan.index');
        Route::post('tagihan', [TagihanAdminController::class, 'store'])->name('tagihan.store');
        Route::put('tagihan/{id}', [TagihanAdminController::class, 'update'])->name('tagihan.update');
        Route::delete('tagihan/{id}', [TagihanAdminController::class, 'destroy'])->name('tagihan.destroy');
        Route::post('tagihan/import', [TagihanAdminController::class,'import'])->name('tagihan.import');
        Route::post('tagihan/{id}/verify', [TagihanAdminController::class,'verify'])->name('tagihan.verify');

        // Route Tracer Study
        Route::get('tracer-study', [TracerStudyAdminController::class, 'index'])->name('tracer_study.index');
        Route::delete('tracer-study/{id}', [TracerStudyAdminController::class, 'destroy'])->name('tracer_study.destroy');

        // Route Legalisir Ijazah
        Route::get('legalisir', [LegalisirIjazahAdminController::class,'index'])->name('legalisir.index');
        Route::get('legalisir/{id}', [LegalisirIjazahAdminController::class,'show'])->name('legalisir.show');
        Route::put('legalisir/{id}/update-biaya', [LegalisirIjazahAdminController::class,'updateBiaya'])->name('legalisir.updateBiaya');
        Route::put('legalisir/{id}/proses-bayar', [LegalisirIjazahAdminController::class,'prosesBayar'])->name('legalisir.prosesBayar');
        Route::put('legalisir/{id}/input-resi', [LegalisirIjazahAdminController::class,'inputResi'])->name('legalisir.inputResi');
        Route::delete('legalisir/{id}', [LegalisirIjazahAdminController::class,'destroy'])->name('legalisir.destroy');

        // Route Buku Wisuda
        Route::get('buku-wisuda', [BukuWisudaAdminController::class, 'index'])
        ->name('bukuWisuda.index');
        Route::post('buku-wisuda', [BukuWisudaAdminController::class, 'store'])
            ->name('bukuWisuda.store');
        Route::put('buku-wisuda/{id_buku_wisuda}', [BukuWisudaAdminController::class, 'update'])
            ->name('bukuWisuda.update');
        Route::delete('buku-wisuda/{id_buku_wisuda}', [BukuWisudaAdminController::class, 'destroy'])
            ->name('bukuWisuda.destroy');

        // Route Perusahaan Wisuda
        Route::get('perusahaan', [PerusahaanAdminController::class, 'index'])
        ->name('perusahaan.index');
        Route::post('perusahaan', [PerusahaanAdminController::class, 'store'])
            ->name('perusahaan.store');
        Route::put('perusahaan/{id_perusahaan}', [PerusahaanAdminController::class, 'update'])
            ->name('perusahaan.update');
        Route::delete('perusahaan/{id_perusahaan}', [PerusahaanAdminController::class, 'destroy'])
            ->name('perusahaan.destroy');

        // Route Loker
        Route::get('loker', [LokerAdminController::class, 'index'])
            ->name('loker.index');
        Route::post('loker', [LokerAdminController::class, 'store'])
            ->name('loker.store');
        Route::put('loker/{id_loker}', [LokerAdminController::class, 'update'])
            ->name('loker.update');
        Route::delete('loker/{id_loker}', [LokerAdminController::class, 'destroy'])
            ->name('loker.destroy');

        // Route User
        Route::get('users', [UserAdminController::class,'index'])->name('users.index');
        Route::post('users', [UserAdminController::class,'store'])->name('users.store');
        Route::put('users/{id}', [UserAdminController::class,'update'])->name('users.update');
        Route::post('users/import', [UserAdminController::class,'import'])->name('users.import');
        Route::post('users/{id}/reset-password', [UserAdminController::class,'resetPassword'])->name('users.resetPassword');
        Route::delete('users/{id}', [UserAdminController::class,'destroy'])->name('users.destroy');            

        // Route Setting
        Route::get('settings', [SettingAdminController::class,'edit'])
            ->name('settings.edit');
        Route::put('settings', [SettingAdminController::class,'update'])
            ->name('settings.update');

    });
});

Route::prefix('')->name('alumni.')->group(function () {
    Route::get('login', [AlumniAuth::class, 'showLoginForm'])->name('login');
    Route::post('login', [AlumniAuth::class, 'login']);
    Route::post('logout', [AlumniAuth::class, 'logout'])->name('logout');

    Route::middleware('auth:alumni')->group(function () {
        Route::get('/', [AlumniDashboardController::class, 'index'])->name('dashboard.index');

        // Route Ijazah
        Route::get('/dokumen', [DokumenAlumniController::class, 'index'])->name('dokumen.index');
        Route::get('/dokumen/download/{id_data_alumni}', [DokumenAlumniController::class, 'download'])->name('dokumen.download');

        // Route Sertifiakt
        Route::get('/sertifikat', [SertifikatAlumniController::class, 'index'])->name('sertifikat.index');
        Route::get('/sertifikat/download/{id_data_alumni}', [SertifikatAlumniController::class, 'download'])->name('sertifikat.download');

        Route::get('tagihan', [TagihanAlumniController::class,'index'])->name('tagihan.index');
        Route::post('tagihan/{id}/bayar', [TagihanAlumniController::class,'bayar'])->name('tagihan.bayar');

        // Route Data Alumni
        Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
        
        // Route Profile Alumni
        Route::get('profile', [ProfileAlumniController::class, 'show'])->name('profile');
        Route::put('update-foto/{id_alumni}', [ProfileAlumniController::class, 'updateFoto'])->name('updateFoto');
        Route::post('tambah-pengalaman', [ProfileAlumniController::class, 'tambahPengalaman'])->name('tambahPengalaman');
        Route::delete('/pengalaman-kerja/{id_pengalaman_kerja}', [ProfileAlumniController::class, 'hapusPengalaman'])->name('pengalamanKerja.hapus');

        // Route Ubah Password
        Route::get('ubah-password', [ProfileAlumniController::class, 'showChangePassword'])->name('profile.password');
        Route::post('ubah-password', [ProfileAlumniController::class, 'changePassword'])->name('profile.password.update');

        // Route Buku Wisuda
        Route::get('buku-wisuda', [BukuWisudaController::class, 'index'])->name('buku_wisuda.index');
        Route::get('buku-wisuda/download/{id}', [BukuWisudaController::class, 'download'])->name('buku_wisuda.download');

        // Route Loker
        Route::get('loker', [LokerController::class, 'index'])->name('loker.index');

        // Route Legalisir Ijazah
        Route::get('/legalisir', [LegalisirIjazahController::class, 'create'])->name('legalisir.index');
        Route::post('/legalisir', [LegalisirIjazahController::class, 'store'])->name('legalisir.store'); 
        
        Route::get('/legalisir/logs', [LegalisirIjazahController::class, 'showLogs'])->name('legalisir.logs');
        Route::post('/legalisir/approve/{id}', [LegalisirIjazahController::class, 'approve'])->name('legalisir.approve');
        Route::post('/legalisir/{id}/upload-bukti', [LegalisirIjazahController::class, 'uploadBukti'])->name('legalisir.uploadBukti');
        Route::delete('/legalisir/{id}/delete', [LegalisirIjazahController::class, 'destroy'])->name('legalisir.delete');

        Route::prefix('alumni/tracer-study')->name('tracer_study.')->group(function () {
            Route::get('step1', [TracerStudyController::class, 'createStep1'])->name('step1');
            Route::post('step1', [TracerStudyController::class, 'storeStep1'])->name('storeStep1');
        
            Route::get('step2/{id}', [TracerStudyController::class, 'createStep2'])->name('step2');
            Route::post('step2/{id}', [TracerStudyController::class, 'storeStep2'])->name('storeStep2');
        
            Route::get('step3/{id}', [TracerStudyController::class, 'createStep3'])->name('step3');
            Route::post('step3/{id}', [TracerStudyController::class, 'storeStep3'])->name('storeStep3');
        
            Route::get('step4/{id}', [TracerStudyController::class, 'createStep4'])->name('step4');
            Route::post('step4/{id}', [TracerStudyController::class, 'storeStep4'])->name('storeStep4');
        
            Route::get('completed', [TracerStudyController::class, 'completed'])->name('completed');
        });

        // Route Daftar Perusahaan
        Route::get('daftar-perusahaan', [DaftarPerusahaanController::class, 'index'])->name('daftar_perusahaan.index');
    });
});


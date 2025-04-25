<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracerStudyTable extends Migration
{
    public function up()
    {
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            // Step 1 - Verifikasi Data
            $table->string('nis');
            $table->string('nisn');
            $table->string('nama_siswa');
            $table->string('jurusan');
            $table->year('tahun_lulus');
            $table->string('email');
            $table->string('nomor_wa');

            // Step 2 - Kuisioner Sekolah
            $table->text('pembelajaran')->nullable();
            $table->text('praktek')->nullable();
            $table->text('sarpras')->nullable();
            $table->text('pkl')->nullable();
            $table->text('biaya')->nullable();

            // Step 3 - Kuisioner Dunia Kerja
            $table->text('mencari_pekerjaan')->nullable(); 
            $table->text('proses_mencari_kerja')->nullable();
            $table->text('jml_perusahaan')->nullable();
            $table->text('respon_perusahaan')->nullable();
            $table->text('undangan_perusahaan')->nullable();
            $table->text('status_kerja')->nullable();

            // Step 4 - Data Diri
             // Menyimpan status pekerjaan sebelum lulus (Ya/Tidak)
            $table->string('status_pekerjaan_sebelum_lulus')->nullable();
             // Menyimpan durasi dalam bulan sejak lulus atau sebelum lulus
            $table->integer('durasi_pekerjaan')->nullable(); 
            $table->string('pekerjaan')->nullable();
            $table->string('perusahaan')->nullable();
            $table->string('posisi_pekerjaan')->nullable();
            $table->string('tahun_masuk_pekerjaan')->nullable();
            $table->string('gaji')->nullable();
            $table->integer('etika')->nullable()->default(0);  // Nilai 0-3, misalnya
            $table->integer('bahasa_inggris')->nullable()->default(0); // Nilai 0-3
            $table->integer('komunikasi')->nullable()->default(0); // Nilai 0-3
            $table->integer('kerja_sama')->nullable()->default(0); // Nilai 0-3
            $table->integer('pengembangan_diri')->nullable()->default(0); // Nilai 0-3
            $table->string('saran')->nullable();


            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracer_studies');
    }
}

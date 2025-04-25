<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengalaman_kerja', function (Blueprint $table) {
            $table->id('id_pengalaman_kerja');
            $table->unsignedBigInteger('id_alumni'); // Relasi ke alumni
            $table->string('nama_pekerjaan');
            $table->string('nama_perusahaan');
            $table->year('tahun_awal');
            $table->year('tahun_akhir');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengalaman_kerja');
    }
};

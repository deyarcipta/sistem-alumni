<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database/migrations/xxxx_xx_xx_create_alumnis_table.php
        Schema::create('alumni', function (Blueprint $table) {
            $table->id('id_alumni');
            $table->string('nama');
            $table->string('nis')->unique();
            $table->string('nisn')->unique();
            $table->string('id_jurusan');
            $table->string('password');
            $table->string('tahun_lulus');
            $table->string('foto');
            $table->string('status')->nullable();
            $table->string('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('email')->unique();
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('sekolah_sd')->nullable();
            $table->string('sekolah_smp')->nullable();
            $table->string('sekolah_smk');
            $table->string('tahun_lulus_sd')->nullable();
            $table->string('tahun_lulus_smp')->nullable();
            $table->string('pengalaman_kerja')->nullable();
            $table->string('keterampilan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};

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
        Schema::create('legalisir_ijazah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alumni');
            // $table->foreign('id_alumni')->references('id_alumni')->on('alumni')->onDelete('cascade');
            $table->string('email');
            $table->string('telepon');
        
            $table->foreignId('provinsi_id');
            $table->foreignId('kota_id');
            $table->foreignId('kecamatan_id');
            $table->foreignId('kelurahan_id');
        
            $table->string('nama_jalan');
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('nomor_rumah')->nullable();
            $table->string('kode_pos');
        
            $table->string('jasa_kirim'); // JNE, J&T, dll
            $table->integer('biaya_pengiriman')->nullable()->default(null); // Biaya pengiriman, jika ada
            $table->enum('status', ['pending', 'proses', 'dikirim', 'selesai'])->default('pending'); // Status permohonan

            $table->string('bukti_pembayaran')->nullable(); // Bukti pembayaran, jika ada
            $table->enum('status_pembayaran', ['belum bayar', 'sudah bayar', 'pengecekan'])->default('belum bayar'); // Status pembayaran
            $table->string('resi')->nullable();
        
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legalisir_ijazah');
    }
};

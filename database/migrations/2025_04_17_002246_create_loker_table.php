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
        Schema::create('loker', function (Blueprint $table) {
            $table->id('id_loker');	
            $table->string('id_perusahaan');
            $table->string('judul_loker');
            $table->string('foto'); 
            $table->text('deskripsi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->string('lokasi');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loker');
    }
};

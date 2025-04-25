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
        Schema::create('buku_wisuda', function (Blueprint $table) {
            $table->id('id_buku_wisuda');
            $table->string('tahun');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file'); // nama file dokumen buku wisuda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_wisuda');
    }
};

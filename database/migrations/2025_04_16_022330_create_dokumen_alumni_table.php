<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumen_alumni', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->foreignId('id_alumni')->constrained('alumni', 'id_alumni')->onDelete('cascade');
            $table->string('jenis_dokumen'); // Contoh: Ijazah, Transkrip Nilai, SKPI
            $table->string('file_path');     // Path file
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_alumni');
    }
};

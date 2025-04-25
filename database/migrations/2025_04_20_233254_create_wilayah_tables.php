<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provinsi', function (Blueprint $table) {
            $table->id(); // auto-increment
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('kota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provinsi_id')->constrained('provinsi')->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('kecamatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kota_id')->constrained('kota')->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('kelurahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->onDelete('cascade');
            $table->string('nama');
            $table->string('kode_pos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelurahan');
        Schema::dropIfExists('kecamatan');
        Schema::dropIfExists('kota');
        Schema::dropIfExists('provinsi');
    }
};

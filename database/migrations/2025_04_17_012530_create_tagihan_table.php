<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('id_tagihan'); // ID tagihan
            $table->string('id_alumni'); // Kolom id_alumni sebagai string
            $table->decimal('nominal', 15, 2); // Nominal tagihan
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['belum_bayar', 'sudah_dibayar', 'proses'])->default('belum_bayar'); // Status tagihan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
};

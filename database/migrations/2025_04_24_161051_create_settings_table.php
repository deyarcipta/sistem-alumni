<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();                                // id
            $table->string('nama_sekolah');              // nama sekolah
            $table->string('singkatan_sekolah');         // singkatan
            $table->string('logo')->nullable();          // nama file logo
            $table->string('no_wa_bkk')->nullable();     // nomor WA BKK
            $table->string('nama_bkk')->nullable();      // nama BKK
            $table->string('email_bkk')->nullable();     // email BKK
            $table->string('bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('atas_nama')->nullable();
            $table->text('alamat_sekolah')->nullable();  // alamat lengkap
            $table->timestamps();
        });

        // Insert satu baris default
        \DB::table('settings')->insert([
            'nama_sekolah'       => 'SMA Negeri 1 Contoh',
            'singkatan_sekolah'  => 'SMAN1C',
            'logo'               => 'logo_default.png',
            'no_wa_bkk'          => '+6281234567890',
            'nama_bkk'           => 'BKK SMAN1C',
            'email_bkk'          => 'bkk@sman1c.sch.id',
            'bank'               => 'BCA',
            'nomor_rekening'     => '1234567890',
            'atas_nama'          => 'SMK Negeri 1 Contoh',
            'alamat_sekolah'     => 'Jl. Pendidikan No.1, Contoh City',
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

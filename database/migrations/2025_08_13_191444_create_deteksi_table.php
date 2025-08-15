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
        Schema::create('deteksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('usia');
            $table->integer('usia_val');
            $table->string('jenis_kelamin'); // input asli (string)
            $table->integer('jk_val'); // hasil konversi ke angka
            $table->string('telepon')->nullable();
            $table->string('aktivitas')->nullable(); // input asli (string)
            $table->integer('aktivitas_val')->nullable(); // hasil kategori
            $table->string('imt')->nullable();
            $table->integer('imt_val')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->integer('td_val')->nullable();
            $table->string('hipertensi')->nullable(); // input asli
            $table->integer('hipertensi_val')->nullable();
            $table->double('gula_darah')->nullable(); // input asli
            $table->integer('gula_darah_val')->nullable();
            $table->string('kardiovaskular')->nullable(); // input asli
            $table->integer('kardio_val')->nullable();
            $table->string('hasil');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deteksi');
    }
};

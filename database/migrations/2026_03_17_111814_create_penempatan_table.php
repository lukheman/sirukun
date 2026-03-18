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
        Schema::create('penempatan', function (Blueprint $table) {
            $table->id('id_penempatan');
            $table->unsignedBigInteger('id_pengajuan');
            $table->unsignedBigInteger('id_unit');
            $table->date('tanggal_masuk');
            $table->timestamps();

            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
            $table->foreign('id_unit')->references('id_unit')->on('unit_rumah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penempatan');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keluhan', function (Blueprint $table) {
            $table->id('id_keluhan');
            $table->foreignId('id_warga')->constrained('warga', 'id_warga')->onDelete('cascade');
            $table->string('judul');
            $table->text('isi');
            $table->string('status')->default('Menunggu'); // Menunggu, Diproses, Selesai
            $table->text('balasan')->nullable();
            $table->timestamp('dibalas_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhan');
    }
};

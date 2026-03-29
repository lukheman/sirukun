<?php

use App\Enums\StatusPengajuan;
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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->unsignedBigInteger('id_warga');
            $table->string('status_pengajuan')->default(StatusPengajuan::MENUNGGU->value);
            $table->timestamps();

            $table->foreign('id_warga')->references('id_warga')->on('warga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};

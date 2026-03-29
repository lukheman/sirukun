<?php

use App\Enums\StatusKetersediaan;
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
        Schema::create('unit_rumah', function (Blueprint $table) {
            $table->id('id_unit');
            $table->string('blok');
            $table->string('nomor');
            $table->string('status_ketersediaan')->default(StatusKetersediaan::TERSEDIA->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_rumah');
    }
};

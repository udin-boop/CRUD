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
    Schema::create('brands', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('negara_asal');
        $table->Integer('tahun_berdiri')->nullable();
        $table->date('tanggal_berdiri')->nullable(); // Format YYYY-MM-DD
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};

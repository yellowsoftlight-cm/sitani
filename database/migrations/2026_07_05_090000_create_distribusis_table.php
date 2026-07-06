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
        Schema::create('distribusis', function (Blueprint $table) {
            $table->id();
            // Satu laporan panen yang sudah disetujui hanya bisa didistribusikan
            // sekali (unique), agar tidak dihitung dobel ke pasar berbeda.
            $table->foreignId('panen_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('pengurus_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_pasar');
            $table->unsignedInteger('jumlah_kg'); // boleh <= berat panen terkait
            $table->unsignedBigInteger('harga_per_kg'); // dalam Rupiah
            $table->unsignedBigInteger('total_nilai'); // jumlah_kg * harga_per_kg
            $table->date('tanggal_kirim');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusis');
    }
};

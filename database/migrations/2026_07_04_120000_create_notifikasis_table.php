<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel notifikasi per pengguna. Setiap baris adalah satu notifikasi
     * milik satu user (bukan notifikasi global), sehingga riwayat baca/belum
     * baca bisa dilacak secara akurat per akun.
     */
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tipe'); // mis: panen_masuk, panen_disetujui, panen_ditolak, anggota_baru, bagi_hasil, role_diubah, chat
            $table->string('judul');
            $table->text('pesan');
            $table->json('data')->nullable(); // payload tambahan, mis. id panen terkait, url tujuan
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};

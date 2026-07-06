<?php

namespace App\Services;

use App\Events\NotifikasiDibuat;
use App\Models\Notifikasi;
use App\Models\User;

/**
 * Titik pusat untuk membuat & mengirim notifikasi ke pengguna.
 * Setiap pemanggilan akan menyimpan baris notifikasi ke database
 * SEKALIGUS memancarkan event real-time lewat broadcasting (Pusher).
 */
class NotifikasiService
{
    /**
     * Kirim satu notifikasi ke satu user tertentu.
     */
    public static function kirim(int $userId, string $tipe, string $judul, string $pesan, array $data = []): Notifikasi
    {
        $notifikasi = Notifikasi::create([
            'user_id' => $userId,
            'tipe' => $tipe,
            'judul' => $judul,
            'pesan' => $pesan,
            'data' => $data,
        ]);

        // Broadcasting bersifat "best effort" — kalau Pusher belum dikonfigurasi
        // atau sedang tidak bisa dihubungi, jangan sampai proses penyimpanan
        // notifikasi ke database ikut gagal. Sistem tetap jalan lewat fallback
        // polling di sisi frontend.
        try {
            broadcast(new NotifikasiDibuat($notifikasi));
        } catch (\Throwable $e) {
            report($e);
        }

        return $notifikasi;
    }

    /**
     * Kirim notifikasi yang sama ke seluruh user dengan role tertentu,
     * misalnya memberitahu semua Pengurus saat ada laporan panen baru.
     *
     * @param  int|null  $kecualiUserId  ID user yang dikecualikan (mis. pelaku aksi itu sendiri)
     * @return \Illuminate\Support\Collection<int, Notifikasi>
     */
    public static function kirimKeRole(string $role, string $tipe, string $judul, string $pesan, array $data = [], ?int $kecualiUserId = null)
    {
        return User::where('role', $role)
            ->when($kecualiUserId, fn ($query) => $query->where('id', '!=', $kecualiUserId))
            ->get()
            ->map(fn (User $user) => self::kirim($user->id, $tipe, $judul, $pesan, $data));
    }
}

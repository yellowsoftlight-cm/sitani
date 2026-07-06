<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Di sinilah kita mendaftarkan seluruh channel broadcasting yang dipakai
| aplikasi. Laravel otomatis membuat rute otorisasi (/broadcasting/auth)
| berdasarkan berkas ini, dipanggil oleh Laravel Echo saat client mencoba
| subscribe ke channel privat/presence.
|
*/

// Channel privat notifikasi — hanya pemilik akun yang boleh mendengarkan
// notifikasinya sendiri.
Broadcast::channel('App.Models.User.{id}', function (User $user, int $id) {
    return (int) $user->id === $id;
});

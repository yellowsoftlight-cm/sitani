<?php

namespace App\Events;

use App\Models\Notifikasi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Dipancarkan setiap kali ada notifikasi baru dibuat untuk seorang user.
 * Frontend (Laravel Echo) mendengarkan channel privat "App.Models.User.{id}"
 * lalu memperbarui lonceng notifikasi secara real-time tanpa reload halaman.
 */
class NotifikasiDibuat implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(public Notifikasi $notifikasi)
    {
    }

    /**
     * Channel privat milik user penerima notifikasi.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->notifikasi->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'notifikasi.baru';
    }

    /**
     * Payload ringkas yang dikirim ke client — hindari mengirim seluruh
     * relasi/atribut yang tidak diperlukan oleh widget notifikasi.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->notifikasi->id,
            'tipe' => $this->notifikasi->tipe,
            'judul' => $this->notifikasi->judul,
            'pesan' => $this->notifikasi->pesan,
            'data' => $this->notifikasi->data,
            'is_read' => $this->notifikasi->is_read,
            'created_at' => $this->notifikasi->created_at->diffForHumans(),
            'created_at_iso' => $this->notifikasi->created_at->toIso8601String(),
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['panen_id', 'pengurus_id', 'nama_pasar', 'jumlah_kg', 'harga_per_kg', 'total_nilai', 'tanggal_kirim', 'catatan'])]
class Distribusi extends Model
{
    use HasFactory;

    protected $casts = [
        'tanggal_kirim' => 'date',
    ];

    /**
     * Laporan panen yang didistribusikan.
     */
    public function panen(): BelongsTo
    {
        return $this->belongsTo(Panen::class);
    }

    /**
     * Pengurus yang mencatat distribusi ini.
     */
    public function pengurus(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengurus_id');
    }
}

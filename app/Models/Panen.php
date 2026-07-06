<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'no_nota', 'komoditas', 'berat', 'musim', 'status', 'estimasi_bagi_hasil'])]
class Panen extends Model
{
    use HasFactory;

    /**
     * Petani pemilik data panen ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catatan distribusi ke pasar untuk panen ini (jika sudah didistribusikan).
     */
    public function distribusi(): HasOne
    {
        return $this->hasOne(Distribusi::class);
    }
}

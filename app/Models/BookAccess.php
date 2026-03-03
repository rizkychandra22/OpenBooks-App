<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookAccess extends Model
{
    use SoftDeletes;

    protected $table = 'book_access';

    protected $fillable = [
        'user_id',
        'book_id',
        'external_id',
        'granted_at',
        'expired_at',
        'status',
        'access_type'
    ];

    // Casting agar Laravel menganggap kolom ini sebagai objek Carbon (Tanggal)
    protected $casts = [
        'granted_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    /**
     * Relasi ke Member yang memiliki akses
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Buku yang diakses
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
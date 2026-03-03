<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'published_year', // Menggantikan 'year'
        'isbn',           // Standar buku global
        'external_id',    // ID dari Open Library (OL...)
        'description',
        'cover_url',      // Menggantikan 'cover_image'
        'file_path',      // Untuk PDF/EPUB lokal
        'price',          // Untuk jualan novel
        'is_premium',     // Pembeda gratis/berbayar
        'view_count'
    ];

    /**
     * Relationship: Book belongs to a Category.
     * Dibuat optional untuk buku dari API.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: Book can have many access logs/BookAccesss.
     */
    public function bookAccesses(): HasMany
    {
        return $this->hasMany(BookAccess::class);
    }

    /**
     * Relationship: Many to Many with User via Wishlists.
     * Berfungsi sebagai "Rak Buku Pribadi" member.
     */
    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')
                    ->withTimestamps();
    }

    /**
     * Helper: Mengecek apakah buku ini berasal dari API luar.
     */
    public function isExternal(): bool
    {
        return !empty($this->external_id);
    }
}
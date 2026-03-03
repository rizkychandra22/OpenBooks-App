<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'code_name'];

    /**
     * Get the books for the category.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}

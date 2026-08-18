<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'bio',
        'credentials',
        'profile_url',
        'role',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function authoredPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function reviewedPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'reviewer_id');
    }
}

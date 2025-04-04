<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'description',
        'poster_path',
        'backdrop_path',
        'release_date',
        'is_premium',
        'rating',
        'duration',
        'genres',
        'cast',
        'director',
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_premium' => 'boolean',
        'genres' => 'array',
        'cast' => 'array',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getPosterUrlAttribute()
    {
        return $this->poster_path ? 'https://image.tmdb.org/t/p/w500' . $this->poster_path : null;
    }

    public function getBackdropUrlAttribute()
    {
        return $this->backdrop_path ? 'https://image.tmdb.org/t/p/original' . $this->backdrop_path : null;
    }

    public function scopePopular($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('release_date', 'desc');
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }
}

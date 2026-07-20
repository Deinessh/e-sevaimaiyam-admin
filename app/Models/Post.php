<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ['title', 'content', 'image', 'published_at'];
    
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getImageAttribute($value)
    {
        if (!$value) {
            return null;
        }

        if (str_contains($value, '/uploads/')) {
            $parts = explode('/uploads/', $value);
            return '/uploads/' . end($parts);
        }

        return $value;
    }
}

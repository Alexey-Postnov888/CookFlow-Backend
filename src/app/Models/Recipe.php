<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'description',
        'ingredients',
        'steps',
        'author_id',
        'category_id',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
    ];
}

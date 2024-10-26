<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'detail',
        'price',
        'buy',
        'sell',
        'favorite_count',
        'comment_count',
    ];
}

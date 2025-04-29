<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'seller',
        'purchaser',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

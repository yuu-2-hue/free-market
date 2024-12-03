<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Profile;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'product_id',
        'comment',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}

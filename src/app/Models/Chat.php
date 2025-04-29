<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Room;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'sender',
        'message',
        'image',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

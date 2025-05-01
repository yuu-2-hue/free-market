<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'post_code',
        'address',
        'building',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // プロフィールの設定をしたかどうかの判定
    public function scopeIsAddProfile()
    {
        if($this->where('user_id', Auth::id())->exists())
        {
            return true;
        }

        return false;
    }

    // プロフィールデータベースにレコードがあるときにデータを取得
    public function scopeGetProfileData()
    {
        $data = [];
        if($this->where('user_id', Auth::id())->exists())
        {
            $profiles = $this->where('user_id', Auth::id())->get();
            foreach($profiles as $profile)
            {
                $data = $profile;
            }
        }

        return $data;
    }

}

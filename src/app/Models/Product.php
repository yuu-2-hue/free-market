<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Condition;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'condition_id',
        'name',
        'brand',
        'image',
        'detail',
        'price',
        'buy',
        'sell',
    ];

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword))
        {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'product_category','product_id','category_id',);
    }

    // $txtで指定したデータを取得
    public function scopeGetProducts($query, $txt)
    {
        $data = [];
        $products = $this->where($txt, Auth::id())->get();
        return $products;
    }
}

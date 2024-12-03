<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;

use App\Http\Requests\ExhibitionRequest;

class SellController extends Controller
{
    // 出品画面を表示
    public function sell(Request $request)
    {
        $categories = Category::All();
        $conditions = Condition::All();
        $keyword = $request->session()->get('keyword');
        return view('sell', compact('categories', 'conditions', 'keyword'));
    }

    // 出品機能
    public function exhibit(ExhibitionRequest $request)
    {
        // アップロードされたファイル名を取得し保存
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/img', $file_name);

        // 商品データベースに登録
        Product::create([
            'condition_id' => $request->condition,
            'name' => $request->name,
            'brand' => 'ブランド',
            'image' => 'img/'.$file_name,
            'detail' => $request->explanation,
            'price' => $request->price,
            'buy' => 0,
            'sell' => Auth::id(),
        ]);

        // ProductCategoryTableの更新
        $categories = Category::All();
        $data = [];
        foreach($categories as $category)
        {
            for($i = 0; $i < count($request->category); $i++)
            {
                if($category->id == $request->category[$i])
                {
                    array_push($data, $category->id);
                }
            }
        }
        $post = Product::orderBy('id', 'desc')->first();
        Product::Find($post->id)->categories()->sync($data);

        return redirect()->route('mypage');
    }
}

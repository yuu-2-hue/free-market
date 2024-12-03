<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Condition;
use App\Models\Comment;
use App\Models\Favorite;

use App\Http\Requests\CommentRequest;

class DetailController extends Controller
{
    // 商品詳細画面の表示
    public function detail(Request $request, $itemId)
    {
        // 各種データベースを取得
        $product = Product::Find($itemId);
        $condition = Condition::Find($product->condition_id);
        $comments = Comment::with('profile')->where('product_id', $itemId)->get();
        $favorites = Favorite::with('user')->with('product')->where('product_id', $itemId)->get();
        $keyword = $request->session()->get('keyword');

        // いいねしているか取得
        $isFavorite = false;
        foreach($favorites as $favorite)
        {
            if(Auth::id() == $favorite->user_id) $isFavorite = true;
        }
        $request->session()->put('isFavorite', $isFavorite);

        // コメント数といいね数を取得
        $commentCount = count($comments);
        $favoriteCount = count($favorites);

        return view('detail', compact('product', 'condition', 'comments', 'commentCount', 'favoriteCount', 'isFavorite', 'keyword'));
    }

    // いいね機能
    public function addFavorite(Request $request)
    {
        if(Auth::check())
        {
            $isFavorite = $request->session()->get('isFavorite');
            $favorites = Favorite::with('user')->with('product')->where('product_id', $request->product_id)->get();

            if($isFavorite)
            {
                foreach($favorites as $favorite)
                {
                    if(Auth::id() == $favorite->user_id) $favorite->delete();
                }
                $isFavorite = false;
            }
            else
            {
                Favorite::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                ]);
                $isFavorite = true;
            }
            $request->session()->put('isFavorite', $isFavorite);
        }

        return redirect()->route('detail', $request->product_id);
    }

    // コメント追加機能
    public function addComment(CommentRequest $request)
    {
        if(Auth::check())
        {
            Comment::create([
                'profile_id' => Auth::id(),
                'product_id' => $request->product_id,
                'comment' => $request->comment,
            ]);
        }

        return redirect()->route('detail', $request->product_id);
    }
}

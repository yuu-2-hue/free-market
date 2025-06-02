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
        $user = Auth::user();
        $product = Product::Find($itemId);
        $condition = Condition::Find($product->condition_id);
        $comments = Comment::with('profile')->where('product_id', $itemId)->get();
        $favorites = $user->favorites()->where('product_id', $itemId)->get();
        $keyword = $request->session()->get('keyword');

        // いいねしているか取得
        $isFavorited = $user->favorites()->where('product_id', $itemId)->exists();

        // コメント数といいね数を取得
        $commentCount = count($comments);
        $favoriteCount = count($favorites);

        return view('detail', compact('product', 'condition', 'comments', 'commentCount', 'favoriteCount', 'isFavorited', 'keyword'));
    }

    // いいね機能
    public function toggle(Request $request, $itemId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($itemId);

        $isFavorited = $user->favorites()->where('product_id', $itemId)->exists();
        if($isFavorited){
            $user->favorites()->detach($itemId);
        }
        else{
            $user->favorites()->attach($itemId);
        }

        $newCount = $product->favorites()->count();

        return response()->json([
            'favorited' => !$isFavorited,
            'count' => $newCount,
        ]);
    }

    // コメント追加機能
    public function addComment(CommentRequest $request)
    {
        if(Auth::check())
        {
            $comment = Comment::create([
                'profile_id' => Auth::id(),
                'product_id' => $request->product_id,
                'comment' => $request->comment,
            ]);
        }

        $comment->load('profile');

        return response()->json([
            'message' => 'コメントを投稿しました。',
            'comment' => $comment
        ]);
    }
}

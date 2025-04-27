<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Favorite;

class ListController extends Controller
{
    // 商品一覧画面の表示
    public function index(Request $request)
    {
        $products = Product::All();
        $mylists = Product::with('favorites')->whereHas('favorites', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $keyword = $request->session()->get('keyword');
        if ($keyword != null) $products = $request->session()->get('searchLists');

        return view('index',  compact('products', 'mylists', 'keyword'));
    }

    // 検索機能
    public function search(Request $request)
    {
        $searchLists = Product::with('conditions')->KeywordSearch($request->keyword)->get();

        $request->session()->put('searchLists', $searchLists);
        $request->session()->put('keyword', $request->keyword);

        return redirect()->route('index');
    }

}

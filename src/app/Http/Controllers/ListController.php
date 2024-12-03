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
        $favorites = Favorite::All();
        $tab = $request->query('tab');
        if($tab == null) $tab = 'list';
        $lists = [];

        $keyword = $request->session()->get('keyword');
        if($keyword != null) $products = $request->session()->get('searchLists');

        if($tab == 'mylist')
        {
            if(Auth::check())
            {
                foreach($products as $product)
                {
                    if($product->sell != Auth::id())
                    {
                        foreach($favorites as $favorite)
                        {
                            if(Auth::id() == $favorite->user_id && $product->id == $favorite->product_id)
                            {
                                array_push($lists, $product);
                            }
                        }
                    }
                }
            }
        }
        else
        {
            if(Auth::check())
            {
                foreach($products as $product)
                {
                    if($product->sell != Auth::id())
                    {
                        array_push($lists, $product);
                    }
                }
            }
            else
            {
                $lists = $products;
            }
        }

        return view('index',  compact('lists', 'tab', 'keyword'));
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

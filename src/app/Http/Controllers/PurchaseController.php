<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Profile;
use App\Models\Payment;

use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    // 購入画面の表示
    public function purchase(Request $request, $itemId)
    {
        $product = Product::Find($itemId);
        if($product->buy != 0)
        {
            return redirect()->route('detail', $itemId);
        }

        $payments = Payment::All();
        $profile = Profile::GetProfileData();
        $keyword = $request->session()->get('keyword');

        return view('purchase', compact('product', 'profile', 'payments', 'keyword'));
    }

    // 購入機能
    public function store(PurchaseRequest $request, $itemId)
    {
        $product = Product::Find($itemId);
        if($product == null)
        {
            return redirect()->route('purchase', $itemId);
        }

        $product->update(['buy' => Auth::id()]);
        $payment = '';
        if($request->payment == 1) $payment = 'konbini';
        else if($request->payment == 2) $payment = 'card';

        $line_item = [
            'price_data' => [
                'currency' => 'jpy',
                'unit_amount' => $product->price,
                'product_data' => [
                    'name' => $product->name,
                    'description' => $product->detail,
                ],
            ],
            'quantity'    => 1,
        ];

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => [$payment],
            'line_items'           => [$line_item],
            'success_url'          => route('mypage'),
            'cancel_url'           => route('purchase', $product->id),
            'mode'                 => 'payment',
        ]);

        return view('checkout', ['session' => $session, 'publicKey' => env('STRIPE_PUBLIC_KEY')]);
    }

    // 住所変更画面の表示
    public function address(Request $request, $itemId)
    {
        $product_id = Product::Find($itemId)->id;
        $profile = Profile::GetProfileData();
        $keyword = $request->session()->get('keyword');

        return view('address', compact('profile', 'product_id', 'keyword'));
    }

    // 住所変更機能
    public function edit(Request $request, $itemId)
    {
        $form = $request->only('post_code', 'address', 'building');
        unset($form['_token']);
        Profile::GetProfileData()->update($form);

        return redirect()->route('purchase', $itemId);
    }
}

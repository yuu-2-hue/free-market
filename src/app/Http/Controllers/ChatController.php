<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Chat;
use App\Models\Room;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index($productId, $seller, $purchaser)
    {
        $user = User::Find(Auth::id());
        $product = Product::Find($productId);
        $rooms = Room::where('product_id', $productId)->where('seller', $seller)->where('purchaser', $purchaser)->get();
        $receiver = User::Find($seller);
        $chats = [];
        foreach($rooms as $room)
        {
            $chats = Chat::where('room_id', $room->id)->get();
            if ($product->sell == Auth::id()) {
                $receiver = User::Find($room->purchaser);
            } else {
                $receiver = User::Find($room->seller);
            }
        }

        return view('chat', compact('user', 'product', 'receiver', 'chats'));
    }

    public function store(ChatRequest $request, $productId, $seller, $purchaser)
    {
        $rooms = Room::where('product_id', $productId)->where('seller', $seller)->where('purchaser', $purchaser)->get();
        $roomId = 0;
        if(count($rooms) == 0) {
            Room::create([
                'product_id' => $productId,
                'seller' => $seller,
                'purchaser' => $purchaser,
            ]);
            $roomId = Room::orderBy('id', 'desc')->first()->id;
        }
        else {
            foreach($rooms as $room) {
                $roomId = $room->id;
            }
        }

        if ($request->hasFile('image')) {
            $file_name = $request->file('image')->getClientOriginalName();
            $imagePath = 'img/' . $file_name;
            $request->file('image')->storeAs('public/img', $imagePath);
        }
        else {
            $imagePath = null;
        }

        Chat::create([
            'room_id' => $roomId,
            'sender' => Auth::id(),
            'message' => $request->message,
            'image' => $imagePath,
        ]);

        return redirect()->route('chat.index', ['item_id' => $productId, 'seller_id' => $seller, 'purchaser_id' => $purchaser]);
    }

    public function edit(Request $request, $productId, $seller, $purchaser)
    {
        if($request->has('edit'))
        {
            Chat::Find($request->id)->update([
                'message' => $request->message,
            ]);
        }
        else if($request->has('delete'))
        {
            Chat::Find($request->id)->delete();
        }

        return redirect()->route('chat.index', ['item_id' => $productId, 'seller_id' => $seller, 'purchaser_id' => $purchaser]);
    }

    public function rating(Request $request, $productId, $seller, $purchaser)
    {
        Room::where('product_id', $productId)->where('seller', $seller)->where('purchaser', $purchaser)->delete();

        Rating::Create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->rating,
        ]);

        return redirect()->route('index');
    }

    public function saveMessage(Request $request)
    {
        // メッセージをセッションに保存
        session([
            'chat_message' => $request->input('message'),
        ]);

        return response()->json(['status' => 'ok']);
    }
}

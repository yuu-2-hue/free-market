<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use Illuminate\Http\Request;

use App\Notifications\MessageReceived;

use App\Models\User;
use App\Models\Product;
use App\Models\Chat;
use App\Models\Room;
use App\Models\Rating;

use App\Mail\CompletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    // チャット画面表示
    public function index($productId, $sellerId, $purchaserId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);

        $room = Room::where('product_id', $productId)
            ->where('seller', $sellerId)
            ->where('purchaser', $purchaserId)
            ->first();

        $chats = $room ? Chat::where('room_id', $room->id)->get() : collect();

        // 相手ユーザーの取得
        $receiverId = ($product->sell == $user->id) ? $room->purchaser ?? $purchaserId : $room->seller ?? $sellerId;
        $receiver = User::find($receiverId);

        // 取引中のルーム一覧
        $transactions = Room::where('seller', $user->id)
            ->orWhere('purchaser', $user->id)
            ->get();

        // 未読通知を既読に
        $user->unreadNotifications->markAsRead();

        return view('chat', compact('user', 'product', 'receiver', 'room', 'chats', 'transactions'));
    }

    // メッセージ送信
    public function store(ChatRequest $request, $productId, $sellerId, $purchaserId)
    {
        $room = Room::firstOrCreate([
                'product_id' => $productId,
                'seller' => $sellerId,
                'purchaser' => $purchaserId,
            ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->getClientOriginalName();
            $imagePath = 'img/' . $fileName;
            $request->file('image')->storeAs('public', $imagePath);
        }

        $message = Chat::create([
            'room_id' => $room->id,
            'sender' => Auth::id(),
            'message' => $request->message,
            'image' => $imagePath,
        ]);

        $receiverId = (Auth::id() == $sellerId) ? $purchaserId : $sellerId;
        $receiver = User::find($receiverId);
        $receiver->notify(new MessageReceived($message));

        return redirect()->route('chat.index', [
            'item_id' => $productId,
            'seller_id' => $sellerId,
            'purchaser_id' => $purchaserId,
        ]);
    }

    // メッセージ編集・削除
    public function message(Request $request, $productId, $sellerId, $purchaserId)
    {
        $chat = Chat::findOrFail($request->id);

        if ($request->has('edit')) {
            $chat->update(['message' => $request->message]);
        } elseif ($request->has('delete')) {
            $chat->delete();
        }

        return redirect()->route('chat.index', [
            'item_id' => $productId,
            'seller_id' => $sellerId,
            'purchaser_id' => $purchaserId,
        ]);
    }

    // 評価登録とルーム削除(取引完了)
    public function rating(Request $request, $productId, $sellerId, $purchaserId)
    {
        Room::where('product_id', $productId)
            ->where('seller', $sellerId)
            ->where('purchaser', $purchaserId)
            ->delete();

        Rating::create([
            'user_id' => $sellerId,
            'rating' => $request->rating,
        ]);

        $user = User::Find(Auth::id());
        $seller = User::Find($sellerId);
        $data = ['name' => $user->name];

        Mail::to($seller->email)->send(new CompletedMail($data));

        return redirect()->route('index');
    }

    // 入力内容のセッション保存（自動保存用）
    public function saveMessage(Request $request)
    {
        session(['chat_message' => $request->input('message')]);
        return response()->json(['status' => 'ok']);
    }
}

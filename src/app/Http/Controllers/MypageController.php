<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Profile;
use App\Models\Room;
use App\Models\Rating;

class MypageController extends Controller
{
    // マイページの表示
    public function index(Request $request)
    {
        $userId = Auth::id();

        $sellProducts = Product::where('sell', $userId)->get();
        $buyProducts = Product::where('buy', $userId)->get();

        $rooms = Room::where('seller', $userId)
            ->orWhere('purchaser', $userId)
            ->get();

        $transactionProducts = $rooms->map(function ($room) {
            return Product::find($room->product_id);
        })->filter();

        $profile = Profile::getProfileData();
        $isAddImage = $profile->image !== 'img/kkrn_icon_user_14.png';

        $ratings = Rating::where('user_id', $userId)->get();
        $evaluation = $ratings->isNotEmpty() ? round($ratings->sum('rating') / $ratings->count()) : 0;

        $keyword = $request->session()->get('keyword');

        // 通知関連
        $unreadCounts = Auth::user()
            ->unreadNotifications()
            ->get()
            ->groupBy(fn($n)=> $n->data['room_id'] ?? null)
            ->map(fn($group) => $group->count());
        Auth::user()->notifications()->whereNotNull('read_at')->delete();

        // 通知を取得
        $notifications = Auth::user()
            ->unreadNotifications()
            ->get()
            ->sortByDesc('created_at');

        // 通知を room_id ごとに最新の通知日時を取得
        $latestNotifyTimes = $notifications->groupBy(fn($n) => $n->data['room_id'] ?? null)
            ->map(fn($group) => $group->first()->created_at);

        // 商品とルームの対応を作る
        $combined = collect($rooms)->map(function ($room) use ($latestNotifyTimes) {
            return [
                'product' => Product::find($room->product_id),
                'room' => $room,
                'notify_time' => $latestNotifyTimes[$room->id] ?? null,
            ];
        })->filter(fn($item) => $item['product']); // null 商品を除外

        // 通知の新しい順に並び替え
        $sortedTransactionProducts = $combined->sortByDesc('notify_time')->values();

        return view('mypage', compact(
            'sellProducts',
            'buyProducts',
            'evaluation',
            'keyword',
            'profile',
            'isAddImage',
            'unreadCounts'
        ))->with([
            'sortedTransactionProducts' => $sortedTransactionProducts
        ]);
    }
}

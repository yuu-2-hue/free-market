<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Profile;
use App\Models\User;

use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    // プロフィール編集画面の表示
    public function profile(Request $request)
    {
        $userName = User::Find(Auth::id())->name;

        $isAddProfile = Profile::IsAddProfile();
        $profile = Profile::GetProfileData();
        $keyword = $request->session()->get('keyword');

        return view('profile', compact('profile', 'userName', 'isAddProfile', 'keyword'));
    }

    // マイページの表示
    public function mypage(Request $request)
    {
        $profile = Profile::GetProfileData();
        $lists = [];
        $tab = $request->query('tab');
        if($tab == null) $tab = 'sell';

        if($tab == 'buy')
        {
            $tab = 'buy';
            $lists = Product::GetProducts('buy');
        }
        else
        {
            $lists = Product::GetProducts('sell');
        }

        $isAddImage = false;
        if($profile->image != 'img/kkrn_icon_user_14.png') $isAddImage = true;

        $keyword = $request->session()->get('keyword');

        return view('mypage',  compact('lists', 'tab', 'profile', 'isAddImage', 'keyword'));
    }

    // プロフィールの登録機能
    public function store(ProfileRequest $request)
    {
        if($request->file('image') == null)
        {
            $file_name = 'kkrn_icon_user_14.png';
        }
        else
        {
            $file_name = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/img', $file_name);
        }


        $isAddProfile = $request->session()->get('isAddProfile');
        if($isAddProfile == null)
        {
            Profile::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'image' => 'img/'.$file_name,
                'post_code' => $request->post_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);
        }
        else
        {
            $form = $request->all();
            unset($form['_token']);
            Profile::Find(Auth::id())->update([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'image' => 'img/'.$file_name,
                'post_code' => $request->post_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);
        }
        $request->session()->put('isAddProfile', true);

        return redirect()->route('index');
    }
}
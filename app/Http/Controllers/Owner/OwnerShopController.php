<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerShopController extends Controller
{
    // indexページ
    public function index()
    {
        $shops = Auth::user()->shops;
        return view('owner.shop.index', compact('shops'));
    }

    // ショップ情報登録画面表示
    public function create()
    {
        return view('owner.shop.create');
    }

    // ショップ情報登録処理
    public function store(Request $request)
    {
        // dd($request);
        $validationRules = $this->validateRules();
        $validatedData = $request->validate($validationRules);
        // dd($validatedData);

        // ログインユーザーのIDと一緒にデータを保存
        $shop = auth()->user()->shops()->create($validatedData);

        // 支払い情報を保存（別テーブルも下記の書き方でOK）
        // $shop->paymentMethods()->create([
        //     'payment_method' => $validatedData['payment_method']
        // ]);

        for ($i = 1; $i <= 4; $i++) {
            $imageField = "shop_image{$i}";
            if ($request->hasFile($imageField)) {
                $imagePath = $request->file($imageField)->store("shop_images/{$shop->id}", 'public');
                // 保存した画像のパスを対応する shop_image カラムに保存
                $shop->update([$imageField => $imagePath]);
            }
        }

        return redirect()->route('owner.shop.index')->with('success', 'ショップ情報が登録されました');
    }

    public function validateRules()
    {
        return [
            'shop_name' => 'required|string|max:255',
            'business_hours' => 'nullable|string|max:255',
            'regular_holiday' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'access_method' => 'nullable|string',
            'postal_code' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'pref' => 'nullable|string|max:255',
            'map' => 'nullable|string',
            'animal_handler' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'handling_goods' => 'nullable|string',
            'handling_pets'=> 'nullable|string',
            'handling_live_feeds'=> 'nullable|string',
            'handling_frozen_feeds'=> 'nullable|string',
            'handling_dried_feeds'=> 'nullable|string',
            'handling_artificial_feeds'=> 'nullable|string',
            'shop_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_image4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|string|max:255',
            'public_flag' => 'nullable|boolean',
        ];
    }
}




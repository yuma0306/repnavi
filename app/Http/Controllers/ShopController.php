<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request) {
        $pref = $request->input('pref');
        $keyword = $request->input('keyword');

        if(isset($pref)) {
            $query = Shop::query();
            $query->where('pref', 'LIKE', "%{$pref}%");
            $shops = $query->get();
            return view('shop.index', compact('shops', 'pref'));
        }

        if(isset($keyword)) {
            $query = Shop::query();
            $query->where('shop_name', 'LIKE', "%{$keyword}%");
            $shops = $query->get();
            return view('shop.index', compact('shops', 'keyword'));
        }

        $shops = Shop::all();
        return view('shop.index', compact('shops'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Shop;

class ShopGenreBooksController extends Controller
{
    public function index($shopId, $genreId)
    {
        $shop = Shop::findOrFail($shopId);

        if ($shop->books()->where('genre_id', $genreId)->doesntExist()) {
            return response()->json(['message' => 'The specified jenre doesn\'t exist'], 500);
        }

        return $shop->books()->where('genre_id', $genreId)->paginate();
    }

    public function show($shopId, $genreId, $id)
    {
        $shop = Shop::findOrFail($shopId);

        if ($shop->books()->where('genre_id', $genreId)->doesntExist()) {
            return response()->json(['message' => 'The specified jenre doesn\'t exist'], 500);
        }

        return $shop->books()->where('genre_id', $genreId)->find($id);
    }
}

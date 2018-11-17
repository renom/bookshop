<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Shop;
use App\Book;

class ShopBooksController extends Controller
{
    public function index(Request $request, $shopId)
    {
        $validator = Validator::make($request->query(), [
            'sort' => 'in:created_at,-created_at,price,-price',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $sort = $request->query('sort', 'created_at');

        if ($sort[0] === '-') {
            $column = substr($sort, 1);
            $direction = 'desc';
        } else {
            $column = $sort;
            $direction = 'asc';
        }

        return Shop::findOrFail($shopId)->books()->orderBy($column, $direction)->paginate()->getCollection();
    }

    public function show($shopId, $id)
    {
        return Shop::findOrFail($shopId)->books()->find($id);
    }

    public function link($shopId, $id)
    {
        $shop = Shop::findOrFail($shopId);

        if ($shop->books()->where('id', $id)->exists()) {
            return response()->json(['message' => 'The relationship already exists'], 500);
        }

        $book = Book::findOrFail($id);

        $shop->books()->attach($book);

        return $book;
    }

    public function unlink($shopId, $id)
    {
        $shop = Shop::findOrFail($shopId);

        if ($shop->books()->where('id', $id)->doesntExist()) {
            return response()->json(['message' => 'Nothing to delete'], 500);
        }

        $book = Book::findOrFail($id);

        $shop->books()->detach($book);

        return response('', 204);
    }
}

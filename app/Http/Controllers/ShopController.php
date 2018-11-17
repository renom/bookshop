<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Shop;

class ShopController extends Controller
{
    public function index()
    {
        return Shop::paginate();
    }

    public function show($id)
    {
        return Shop::find($id);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($data, [
            'name' => 'required|max:45',
            'address' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return Shop::create($data);
    }

    public function update(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        
        $validator = Validator::make($data, [
            'name' => 'max:45',
            'address' => 'max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $shop = Shop::findOrFail($id);
        $shop->update($data);

        return $shop;
    }

    public function delete(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();

        return response('', 204);
    }
}

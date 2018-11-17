<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Shop;

class ShopsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/shops",
     *     summary="Магазины (список магазинов)",
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Shop")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Shop::paginate()->getCollection();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/shops/{shopId}",
     *     summary="Магазины (один магазин)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Shop")
     *     )
     * )
     */
    public function show($id)
    {
        return Shop::find($id);
    }

    /**
     * @OA\Post(
     *     path="/v1/shops",
     *     summary="Магазины (добавить магазин)",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ShopForm")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Shop")
     *     )
     * )
     */
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

    /**
     * @OA\Patch(
     *     path="/api/v1/shops/{shopId}",
     *     summary="Магазины (редактировать магазин)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ShopForm")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Shop")
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/v1/shops/{shopId}",
     *     summary="Магазины (удалить магазин)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Response(
     *         response=204,
     *         description="successful operation",
     *     )
     * )
     */
    public function delete(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();

        return response('', 204);
    }
}

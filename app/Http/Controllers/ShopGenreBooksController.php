<?php

namespace App\Http\Controllers;

use App\Shop;

class ShopGenreBooksController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/shops/{shopId}/genres/{genreId}/books",
     *     summary="Книги, фильтр по магазину и жанру (список книг)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Parameter(ref="#/components/parameters/genreId"),
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     )
     * )
     */
    public function index($shopId, $genreId)
    {
        $shop = Shop::findOrFail($shopId);

        if ($shop->books()->where('genre_id', $genreId)->doesntExist()) {
            return response()->json(['message' => 'The specified jenre doesn\'t exist'], 500);
        }

        return $shop->books()->where('genre_id', $genreId)->paginate()->getCollection();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/shops/{shopId}/genres/{genreId}/books/{bookId}",
     *     summary="Книги, фильтр по магазину и жанру (одна книга)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Parameter(ref="#/components/parameters/genreId"),
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function show($shopId, $genreId, $id)
    {
        $shop = Shop::findOrFail($shopId);

        if ($shop->books()->where('genre_id', $genreId)->doesntExist()) {
            return response()->json(['message' => 'The specified jenre doesn\'t exist'], 500);
        }

        return $shop->books()->where('genre_id', $genreId)->find($id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Book;

class BookShopsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/books/{bookId}/shops",
     *     summary="Магазины, фильтр по книге (список магазинов)",
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
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
    public function index($bookId)
    {
        return Book::findOrFail($bookId)->shops()->paginate()->getCollection();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/books/{bookId}/shops/{shopId}",
     *     summary="Магазины, фильтр по книге (один магазин)",
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Shop")
     *     )
     * )
     */
    public function show($bookId, $id)
    {
        return Book::findOrFail($bookId)->shops()->find($id);
    }
}

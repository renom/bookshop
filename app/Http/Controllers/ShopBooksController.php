<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Shop;
use App\Book;

class ShopBooksController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/shops/{shopId}/books",
     *     summary="Книги, фильтр по магазину (список книг)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\Parameter(name="sort", in="query", description="Сортировка (по умолчанию по полю created_at). По возрастанию ""sort=created_at"", по убыванию ""sort=-created_at""", @OA\Schema(type="string", enum={"created_at", "-created_at", "price", "-price"})),
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

    /**
     * @OA\Get(
     *     path="/api/v1/shops/{shopId}/books/{bookId}",
     *     summary="Книги, фильтр по магазину (одна книга)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function show($shopId, $id)
    {
        return Shop::findOrFail($shopId)->books()->find($id);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/shops/{shopId}/books/{bookId}",
     *     summary="Книги, фильтр по магазину (привязать книгу к магазину)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/v1/shops/{shopId}/books/{bookId}",
     *     summary="Книги, фильтр по магазину (отвязать книгу от магазина)",
     *     @OA\Parameter(ref="#/components/parameters/shopId"),
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
     *     @OA\Response(
     *         response=204,
     *         description="successful operation",
     *     )
     * )
     */
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

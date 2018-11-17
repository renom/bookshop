<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Book;

class BooksController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/books",
     *     summary="Книги (список книг)",
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
    public function index()
    {
        return Book::paginate()->getCollection();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/books/{bookId}",
     *     summary="Книги (одна книга)",
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function show($id)
    {
        return Book::find($id);
    }

    /**
     * @OA\Post(
     *     path="/v1/books",
     *     summary="Книги (добавить книгу)",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookForm")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($data, [
            'name' => 'required|max:45',
            'description' => 'required|max:255',
            'pages' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'genre_id' => 'required|integer|min:0|exists:genres,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return Book::create($data);
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/books/{bookId}",
     *     summary="Книги (редактировать книгу)",
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookForm")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        
        $validator = Validator::make($data, [
            'name' => 'max:45',
            'description' => 'max:255',
            'pages' => 'integer|min:0',
            'price' => 'numeric|min:0',
            'genre_id' => 'integer|min:0|exists:genres,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $book = Book::findOrFail($id);
        $book->update($data);

        return $book;
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/books/{bookId}",
     *     summary="Книги (удалить книгу)",
     *     @OA\Parameter(ref="#/components/parameters/bookId"),
     *     @OA\Response(
     *         response=204,
     *         description="successful operation",
     *     )
     * )
     */
    public function delete(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response('', 204);
    }
}

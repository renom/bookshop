<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Genre;

class GenresController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/genres",
     *     summary="Жанры (список жанров)",
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Genre")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Genre::paginate()->getCollection();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/genres/{genreId}",
     *     summary="Жанры (один жанр)",
     *     @OA\Parameter(ref="#/components/parameters/genreId"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
     *     )
     * )
     */
    public function show($id)
    {
        return Genre::find($id);
    }

    /**
     * @OA\Post(
     *     path="/v1/genres",
     *     summary="Жанры (добавить жанр)",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GenreForm")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($data, [
            'name' => 'required|max:45',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return Genre::create($data);
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/genres/{genreId}",
     *     summary="Жанры (редактировать жанр)",
     *     @OA\Parameter(ref="#/components/parameters/genreId"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GenreForm")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        
        $validator = Validator::make($data, [
            'name' => 'max:45',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $genre = Genre::findOrFail($id);
        $genre->update($data);

        return $genre;
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/genres/{genreId}",
     *     summary="Жанры (удалить жанр)",
     *     @OA\Parameter(ref="#/components/parameters/genreId"),
     *     @OA\Response(
     *         response=204,
     *         description="successful operation",
     *     )
     * )
     */
    public function delete(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return response('', 204);
    }
}

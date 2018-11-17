<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Book;

class BooksController extends Controller
{
    public function index()
    {
        return Book::paginate();
    }

    public function show($id)
    {
        return Book::find($id);
    }

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

    public function delete(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response('', 204);
    }
}

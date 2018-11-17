<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Genre;

class GenresController extends Controller
{
    public function index()
    {
        return Genre::paginate();
    }

    public function show($id)
    {
        return Genre::find($id);
    }

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

    public function delete(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return response('', 204);
    }
}

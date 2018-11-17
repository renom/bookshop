<?php

namespace App\Http\Controllers;

use App\Book;

class BookShopsController extends Controller
{
    public function index($bookId)
    {
        return Book::findOrFail($bookId)->shops()->paginate()->getCollection();
    }

    public function show($bookId, $id)
    {
        return Book::findOrFail($bookId)->shops()->find($id);
    }
}

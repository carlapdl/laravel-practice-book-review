<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});

//Book Controller
//only() : specifies the only method(s) used in the Book Controller
Route::resource('books', BookController::class)->only(['index', 'show']);

//Review Controller
//scoped() : specifies the scope (i.e.: review is connected to book)
Route::resource('books.review', ReviewController::class)
    ->scoped(['review' => 'book'])
    ->only(['create', 'store']);
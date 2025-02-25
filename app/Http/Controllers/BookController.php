<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * NAME: index
     * DESCRIPTION:
     * - Display the list of books
     * - if title is provided, search function is used
     * - apply the filters if values are given
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter');

        //if $title is not empty, perform the arrow function (fn) for search
        $books = Book::when(
            $title, 
            fn($query, $title) => $query->title($title)
        );

        //match() similar to switch()
        //get the results based on the filter
        $books = match($filter){
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months(),
            default => $books->latest()->withAvgRating()->withReviewsCount()
        };
        
        //$books = $books->get();

        //Store in cache ('key name for the cache', store cache duration in seconds, value)
        $cache_key_name = 'books:'.$filter.':'.$title;
        $books = cache()->remember($cache_key_name, 600, fn() => $books->get());
        //$books = $books->get();

        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * NAME: show
     * DESCRIPTION:
     * - display book details and reviews
     */
    public function show(int $id)
    {
        //Store in cache ('key name for the cache', store cache duration in seconds, value)
        //$cache_key_name = 'book:'.$book->id;
        $cache_key_name = 'book:'.$id;
        $book = cache()->remember($cache_key_name, 600, fn() =>
            //$book->load([
            Book::with([
                'reviews' => fn($query) => $query->latest()
            ])->withAvgRating()->withReviewsCount()->findORFail($id)         
        );

        return view('books.show', ['book' => $book ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

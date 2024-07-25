@extends('layouts.app')

@section('content')
<h1 class="book-title-detail">Create a Review for {{ $book->title }}</h1>

<form name="book-review" method="POST" action="{{ route('books.review.store', $book) }}">
    @csrf
    <label for="review">Review</label>
    <textarea name="review" id="review" class="input" required></textarea>
    <label for="rating">Rating</label>
    <select name="rating" id="rating" class="input" required>
        <option value="">Select Rating</option>
        @for ($i=1; $i<=5; $i++)
            <option value="{{$i}}">{{ $i }}</option>
        @endfor
    </select>
    <button class="btn h-10" type="submit">Save Rating</button> <a href="{{ route('books.show', $book) }}" class="btn h-10">Back to Books List</a>
</form>

@endsection
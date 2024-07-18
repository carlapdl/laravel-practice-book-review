@extends('layouts.app')

@section('content')
<div class="book-top-info">
    <h1 class="book-title-detail">{{ $book->title }}</h1>

    <div class="book-info">
      <div class="book-author mb-4 text-lg font-semibold">by {{ $book->author }}</div>
      <div class="book-rating-detail flex items-center">
        <div>
          {{ number_format($book->reviews_avg_rating, 1) }}
          <span class="book-review-count-detail">
            {{ $book->reviews_count }} {{ Str::plural('review', 5) }}
          </span>
        </div>
      </div>
    </div>
    <div class="flex mt-4">  
        <h2 class="text-xl font-semibold">Reviews</h2>
        <a class="back-to-list" href="{{ route('books.index') }}"><< Back to Books List</a>
    </div>
</div>

<div>
    <ul>
      @forelse ($book->reviews as $review)
        <li class="book-item mb-4">
          <div>
            <div class="mb-2 flex items-center justify-between">
              <div class="font-semibold">{{ $review->rating }}</div>
              <div class="book-review-count">
                {{ $review->created_at->format('M j, Y') }}</div>
            </div>
            <p class="text-gray-700">{{ $review->review }}</p>
          </div>
        </li>
      @empty
        <li class="mb-4">
          <div class="empty-book-item">
            <p class="empty-text text-lg font-semibold">No reviews yet</p>
          </div>
        </li>
      @endforelse
    </ul>
</div>
@endsection
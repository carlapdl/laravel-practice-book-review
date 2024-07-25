<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['review', 'rating'];

    public function book() {

        //A review belongs to 1 book
        return $this->belongsTo(Book::class);
    }

    /**
     * NAME: booted
     * DESCRIPTION:
     * - "booted" method for Review model for cache
     * - if there are changes to a review data (create, update, delete), remove the previous cache [ forget(cache key name) ]
     */
    protected static function booted() {
        static::updated(fn(Review $review) => cache()->forget('book:'.$review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:'.$review->book_id));
        static::created(fn(Review $review) => cache()->forget('book:'.$review->book_id));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function book() {

        //A review belongs to 1 book
        return $this->belongsTo(Book::class);
    }
}

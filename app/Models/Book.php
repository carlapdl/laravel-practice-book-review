<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    public function reviews(){

        //A book can have many reviews
        return $this->hasMany(Review::class);
    }

    /**
     * NAME: scopeTitle
     * DESCRIPTION:
     * - local query scope for title search
     */
    public function scopeTitle(Builder $query, string $title): Builder {
        return $query->where("title","like","%". $title ."%");
    }    
}

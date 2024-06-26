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
     * - required parameter(s): $title 
     */
    public function scopeTitle(Builder $query, string $title): Builder {
        return $query->where("title","like","%". $title ."%");
    }    

    /**
     * NAME: scopePopular
     * DESCRIPTION:
     * - local query scope for getting the list of books order by most number of reviews
     * - optional parameter(s): $from, $to for the date range
     */
    public function scopePopular(Builder $query, $from=null, $to=null): Builder {
        //return $query->withCount('reviews')->orderBy('reviews_count', 'desc');
        return $query->withCount([
            'reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])->orderBy('reviews_count', 'desc');
    }    

    /**
     * NAME: scopeHighestRated
     * DESCRIPTION:
     * - local query scope for getting the list of books order by highest rating 
     * - optional parameter(s): $from, $to for date range
     */
    public function scopeHighestRated(Builder $query, $from=null, $to=null): Builder {
        return $query->withAvg(
            ['reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)]
            , 'rating'
        )->orderBy('reviews_avg_rating', 'desc');
    }

    /**
     * NAME: scopeMinReviews
     * DESCRIPTION:
     * - local query scope for getting the list given the minimum number of reviews
     * - required parameter(s): $mineReviews to specify the minimum number
     */
    public function scopeMinReviews(Builder $query, int $mineReviews): Builder {
        return $query->having('reviews_count', '>=', $mineReviews);
    }

    /**
     * NAME: dateRangeFIlter
     * DESCRIPTION:
     * - private method for date filtering
     */
    private function dateRangeFilter(Builder $query, $from=null, $to=null) {
        if($from && !$to){ //$from has value, $to is empty
            $query->where('created_at', '>=', $from);
        }elseif(!$from && $to){ //$from is empty, $to has value
            $query->where('created_at','<=', $to); 
        }elseif($from && $to){ //both $from and $to has values
            $query->whereBetween('created_at',[$from, $to]);
        }  
    }
}

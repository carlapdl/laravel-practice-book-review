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

    /**
     * NAME: scopePopularLastMonth
     * DESCRIPTION:
     * - local query scope for getting previous month's popular books
     * - books with at least 2 reviews
     */
    public function scopePopularLastMonth(Builder $query): Builder {
        //now()->subMonth : get current date and subtract the month to get the previous month
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(2); //books with at least 2 reviews
    }

    /**
     * NAME: scopePopularLast6Months
     * DESCRIPTION:
     * - local query scope for getting the popular books for the last 6 months
     * - books with at least 5 reviews
     */
    public function scopePopularLast6Months(Builder $query): Builder {
        //now()->subMonths : get current date, specify the number of months in subMonths to get the previous 6th month
        return $query->popular(now()->subMonths(6), now())
            ->highestRated(now()->subMonths(6), now())
            ->minReviews(5); //books with at least 5 reviews
    }

    /**
     * NAME: scopeHighestRatedLastMonth
     * DESCRIPTION:
     * - local query scope for getting the highest rated books of the previous month
     * - books with at least 2 reviews
     */
    public function scopeHighestRatedLastMonth(Builder $query): Builder {
        //now()->subMonth : get current date and subtract the month to get the previous month
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())
            ->minReviews(2); //books with at least 2 reviews
    }

    /**
     * NAME: scopeHighestRatedLast6Months
     * DESCRIPTION:
     * - local query scope for getting the highest rated books for the last 6 months
     * - books with at least 5 reviews
     */
    public function scopeHighestRatedLast6Months(Builder $query): Builder {
        //now()->subMonths : get current date, specify the number of months in subMonths to get the previous 6th month
        return $query->highestRated(now()->subMonths(6), now())
            ->popular(now()->subMonths(6), now())
            ->minReviews(5); //books with at least 5 reviews
    }
}

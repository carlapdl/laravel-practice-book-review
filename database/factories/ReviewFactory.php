<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => null, //should not be null if reviews are to be filled up via data entry
            'review' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1, 5),
            'updated_at'=> fake()->dateTimeBetween('created_at', 'now')
            /*'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at']);
            } */
        ];
    }

    /**
     * NAME: good
     * DESCRIPTION:
     * - state function for good book reviews
     */
    public function good() {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(4, 5)
            ];
        });    
    }

    /**
     * NAME: average
     * DESCRIPTION:
     * - state function for average book reviews
     */
    public function average() {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(2, 5)
            ];
        });    
    }

    /**
     * NAME: bad
     * DESCRIPTION:
     * - state function for bad book reviews
     */
    public function bad() {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(1, 3)
            ];
        });    
    }
}

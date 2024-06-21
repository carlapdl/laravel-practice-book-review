<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            //$table->unsignedBigInteger('book_id');

            $table->text('review');
            $table->unsignedTinyInteger('rating'); //book rating from 1-5 (5: highest)

            $table->timestamps(); //for create and update timestamp

            //Method 1 of defining foreign key
            //$table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');

            //Method 2 of defining foreign key (using shorthand method)
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

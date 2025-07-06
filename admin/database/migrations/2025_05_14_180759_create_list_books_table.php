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
        Schema::create('list_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('genre');
            $table->string('author');
            $table->date('published_date');
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->integer('rating')->nullable();
            $table->text('review')->nullable();
            $table->integer('ratings_count')->default(0);
            $table->integer('reviews_count')->default(0);
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('pages')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_books');
    }
};

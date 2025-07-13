<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('genre');
            $table->integer('pages');
            $table->unsignedBigInteger('publisher_id'); // Add publisher_id column
            $table->foreign('publisher_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key constraint
            $table->date('published_date');
            $table->text('description');
            $table->string('image')->nullable(); // Store image path
            $table->tinyInteger('status')->default('pending'); // Add rating column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
}

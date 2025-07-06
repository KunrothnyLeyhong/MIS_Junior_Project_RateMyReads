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
        Schema::create('reported_comments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('list_books_id')->constrained('list_books')->onDelete('cascade');
        $table->string('first_name');
        $table->string('last_name');
        $table->string('email');
        $table->text('comment');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reported_comments');
    }
};

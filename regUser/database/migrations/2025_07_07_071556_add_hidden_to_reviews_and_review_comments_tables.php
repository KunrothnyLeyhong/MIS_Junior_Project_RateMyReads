<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHiddenToReviewsAndReviewCommentsTables extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('hidden')->default(false)->after('review'); // or after any column you want
        });

        Schema::table('review_comments', function (Blueprint $table) {
            $table->boolean('hidden')->default(false)->after('message');
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });

        Schema::table('review_comments', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
    }
}

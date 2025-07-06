<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportedComment;
use App\Models\ReportedReview;
use App\Models\Review;
use App\Models\User;

class ListBooks extends Model
{
    use HasFactory;

    protected $table = 'books';  // <-- specify your database connection name here

     protected $fillable = [
        'title',
        'author',
        'genre',
        'pages',
        'published_date',
        'description',
        'image',
        'status',
    ];
    
    public function ReportedComment()
    {
        return $this->hasMany(ReportedComment::class, 'list_books_id');
    }

    public function ReportedReview()
    {
        return $this->hasMany(ReportedReview::class, 'list_books_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'publisher_id', 'id');
    }



}
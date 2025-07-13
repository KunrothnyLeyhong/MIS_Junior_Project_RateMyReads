<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'review_id',
        'message', 
        // 'comment',// <-- Change this to the actual column in your DB
        'hidden' // Assuming you want to add hidden status to comments as well
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}

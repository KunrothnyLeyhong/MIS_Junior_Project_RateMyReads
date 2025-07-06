<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedReview extends Model
{
    use HasFactory;

    protected $table = 'reports';  // Explicitly set your table name here

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'reason',
    ];

    public function book()
    {
        return $this->belongsTo(ListBooks::class, 'list_books_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

}

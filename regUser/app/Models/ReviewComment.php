<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewComment extends Model
{
    use HasFactory;

    protected $fillable = ['review_id', 'user_id', 'message'];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
{
    return $this->morphMany(Reports::class, 'reportable');
}

// Add scope for visible reviews
public function scopeVisible($query)
{
    return $query->where('hidden', false);
}

}

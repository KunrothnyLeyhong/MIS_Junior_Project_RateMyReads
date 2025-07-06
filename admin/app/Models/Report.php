<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reportable_id',
        'reportable_type',
        'reason',
        'status',
    ];

    /**
     * Get the owning reportable model (comment or review).
     */
    public function reportable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who made the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

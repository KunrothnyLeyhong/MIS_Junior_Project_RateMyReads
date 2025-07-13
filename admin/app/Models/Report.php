<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'reason',
    'status',
    'reportable_id',
    'reportable_type',
];

    public function reportable()
    {
        return $this->morphTo(); // Automatically loads Review, or other types later
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

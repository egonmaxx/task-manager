<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'estimatedTime',
        'usedTime',
        'userId',
        'description',
        // 'createdAt',
        'completedAt',
        'done'
    ];

    /**
     * Get the phone associated with the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'userId','id');
    }
}

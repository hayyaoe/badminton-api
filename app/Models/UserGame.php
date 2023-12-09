<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function game(): BelongsTo{
        return $this->belongsTo(Game::class,'game_id','id');
    }
}

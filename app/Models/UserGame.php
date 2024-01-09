<?php

namespace App\Models;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

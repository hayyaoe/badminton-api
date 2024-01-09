<?php

namespace App\Models;

use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Set extends Model
{
    use HasFactory;

    protected $fillable =[
        'player1_score',
        'player2_score',
        'game_id'
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

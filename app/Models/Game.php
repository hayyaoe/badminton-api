<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable =[
        'score_1',
        'score_2',
        'information',
        'gamecode',
        'gamestatus'
    ];

    public function sets(): HasMany
    {
        return $this->hasMany(Set::class, 'game_id', 'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'game_id','id');
    }

    public function userGames(): HasMany
    {
        return $this->hasMany(UserGame::class,'game_id','id');
    }
}

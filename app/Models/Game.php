<?php

namespace App\Models;

use App\Models\Set;
use App\Models\Review;
use App\Models\UserGame;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Spartner extends Model
{
    use HasFactory;
    protected $fillable = [
        'user1',
        'user2',
        'user1status',
        'user2status'
    ];

    public function user1data(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'spartners', 'user1', 'user2')
            ->withPivot('user1status', 'user2status');
    }

    public function user2data(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'spartners', 'user2', 'user1')
            ->withPivot('user1status', 'user2status');
    }
}

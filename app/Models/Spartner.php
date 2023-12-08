<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spartner extends Model
{
    use HasFactory;
    protected $fillable = [
        'user1',
        'user2',
        'user1status',
        'user2status'
    ];
}

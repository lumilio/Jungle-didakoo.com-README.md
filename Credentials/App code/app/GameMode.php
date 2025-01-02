<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class GameMode extends Model
{
    protected $fillable = [
        'level',
        'active'
    ];
}

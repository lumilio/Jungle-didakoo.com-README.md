<?php

namespace App;
use App\Mutations\Json;
use Illuminate\Database\Eloquent\Model;
class Game extends Model
{
    protected $fillable = [
        'creator_id',
        'opponent_id',
        'url',
        'status',
        'state'
    ];
    protected $casts = [
        'state' => Json::class,
    ];
    public function creator(){
        return $this->belongsTo(Player::class, 'creator_id');
    }
    public function opponent(){
        return $this->belongsTo(Player::class, 'opponent_id');
    }
}

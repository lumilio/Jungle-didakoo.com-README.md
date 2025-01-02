<?php

namespace App;
use App\Mutations\Json;
use Illuminate\Database\Eloquent\Model;
class GuestGame extends Model
{
    protected $fillable = [
        'creator',
        'opponent',
        'url',
        'status',
        'state'
    ];
    protected $casts = [
        'state' => Json::class,
    ];
}

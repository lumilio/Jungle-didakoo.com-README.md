<?php

use Illuminate\Support\Facades\Broadcast;
Broadcast::channel('game.7', function() {
    return true;
});

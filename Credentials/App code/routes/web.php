<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
Route::post('/api/web3-login-verify', 'Web3LoginController@verify');
Route::post('/api/web3-register-ethwallet', 'Web3LoginController@register');
Route::post('/api/web3-update-ethwallet', 'Web3LoginController@update');
Route::get('/api/getUsers', 'UserController@getUsers');
Route::get('api/user-by-wallet-address/{address}', 'UserController@getUserByWalletAddress');
Route::post('/api/make-game', 'GameController@makeGame');
Route::get('/api/active-game-mode', 'GameController@getActiveGameMode');
Route::post('/api/get-game/{url}', 'GameController@getGame');
Route::get('/api/getSession', 'Web3LoginController@getSession');
Route::get('/api/logout', 'Web3LoginController@logout');
Route::post('/api/login-as-guest', 'Web3LoginController@loginAsGuest');
Route::post('/api/finish-game', 'GameController@finishedGame');
Route::get('/api/delete-game/{url}', 'GameController@deleteGame');
Route::post('/api/set-state', 'GameController@setState');
Route::post('/api/update-player-last-activity', 'Web3LoginController@updatePlayerLastActivity');
Route::get('{any}', 'HomeController@index')->where('any', '.*');

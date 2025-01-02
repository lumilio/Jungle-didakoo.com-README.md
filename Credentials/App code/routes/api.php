<?php

use App\Events\DoStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->get('/user', 'UserController@getUser');
Route::get('/web3-login-message', 'Web3LoginController@message');
Route::get('/get-users', 'UserController@getUsers');
Route::post('/if-there-nft', 'Web3LoginController@IfThereNft');
Route::post('/nft-Collection', 'Web3LoginController@NftCollection');

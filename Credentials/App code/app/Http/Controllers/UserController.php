<?php

namespace App\Http\Controllers;
use App\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function getUsers(Request $request): \Illuminate\Http\JsonResponse
    {
        $players = Player::query()
            ->orderBy('power', 'desc')
            ->orderBy('created_at', 'ASC')
            ->limit($request->query('page') ? $request->query('page') * 60 : null)
            ->get();
        return response()->json(['users' => $players]);
    }
    public function getUserByWalletAddress(Request $request, $address): \Illuminate\Http\JsonResponse
    {
        if ($request->session()->has('isGuest')){
            return response()->json(['user' => ['wallet_address' => $request->session()->get('userSession'), 'balance'=> 0, 'power' => 0, 'color_id' => 1]]);
        }
        $player = Player::where('wallet_address', $address)->first();
        if (!$player) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['user' => $player]);
    }
    public function getUser(Request $request)
    {
        return $request->user();
    }
}

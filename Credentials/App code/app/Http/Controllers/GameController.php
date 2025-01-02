<?php

namespace App\Http\Controllers;
use App\Events\ConnectGame;
use App\Events\DoStep;
use App\Events\QuitGame;
use App\Game;
use App\GuestGame;
use App\Player;
use App\GameMode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class GameController extends Controller
{
    public function makeGame(Request $request)
    {
        do {
            $uniqueUrl = Str::random(30);
        } while (Game::query()->where('url', $uniqueUrl)->first());
        if ($request->session()->has('isGuest')) {
            $player = $request->session()->get('userSession');
            $status = 'started';
            if ($request->multiPlay) {
                $status = 'pending';
            }
            do {
                $colorsCaseA = [
                    "black" => rand(5, 6),
                    "board" => 1,
                    "white" => rand(5, 6),
                ];
            } while ($colorsCaseA["black"] === $colorsCaseA["white"]);
            do {
                $colorsCaseB = [
                    "black" => rand(1, 4),
                    "board" => 2,
                    "white" => rand(1, 4),
                ];
            } while (($colorsCaseB["black"] === $colorsCaseB["white"]) ||
            ($colorsCaseB["white"] === 4 && $colorsCaseB["black"] === 2) ||
            ($colorsCaseB["black"] === 4 && $colorsCaseB["white"] === 2)
            );
            $randomColors = rand(0, 1) ? $colorsCaseA : $colorsCaseB;
            GuestGame::create([
                'creator' => $player,
                'url' => $uniqueUrl,
                'status' => $status,
                'state' => [
                    'state' => $request->state,
                    'turn' => 'white',
                    "colors" => $randomColors
                ]
            ]);
        } else {
            $player = Player::where('wallet_address', $request->address)->first();
            if (!$player) {
                return response()->json(['message' => 'Bed request'], 400);
            }
            $status = 'started';
            if ($request->multiPlay) {
                $status = 'pending';
                $randomColors = [
                    "black" => rand(1, 4),
                    "board" => 2,
                    "white" => $player->color_id,
                ];

            } else {
                do {
                    $colorsCaseA = [
                        "black" => rand(5, 6),
                        "board" => 1,
                        "white" => rand(5, 6),
                    ];
                } while ($colorsCaseA["black"] === $colorsCaseA["white"]);
                do {
                    $colorsCaseB = [
                        "black" => rand(1, 4),
                        "board" => 2,
                        "white" => rand(1, 4),
                    ];
                } while (($colorsCaseB["black"] === $colorsCaseB["white"]) ||
                ($colorsCaseB["white"] === 4 && $colorsCaseB["black"] === 2) ||
                ($colorsCaseB["black"] === 4 && $colorsCaseB["white"] === 2)
                );
                $randomColors = rand(0, 1) == 0 ? $colorsCaseA : $colorsCaseB;
            }
            Game::create([
                'creator_id' => $player->id,
                'url' => $uniqueUrl,
                'status' => $status,
                'state' => [
                    'state' => $request->state,
                    'turn' => 'white',
                    "colors" => $randomColors
                ]
            ]);
        }
        return response()->json(['message' => 'success', 'url' => $uniqueUrl], 201);
    }
    public function setRanks($game)
    {
        $game = $game->toArray();
        if ($game['opponent'] && !is_array($game['opponent'])) {
            $game['opponent'] = $game['opponent']->toArray();
        }
        if ($game['creator'] && !is_array($game['creator'])) {
            $game['creator'] = $game['creator']->toArray();
        }
        if ($game['opponent'] && array_key_exists('wallet_address', $game['opponent']) && $game['opponent']['wallet_address']) {
            $address = $game['opponent']['wallet_address'];
            $opponent = Player::where('wallet_address', $address)->first();
            if ($opponent) {
                $rank = Player::where('power', '>', $opponent->power)->count();
                $rank += Player::where('power', $opponent->power)->where('id', '<', $opponent->id)->count();
                $rank++;
                $game['opponent']['rank'] = $rank;
            }
        }
        if ($game['creator'] && array_key_exists('wallet_address', $game['creator']) && $game['creator']['wallet_address']) {
            $address = $game['creator']['wallet_address'];
            $creator = Player::where('wallet_address', $address)->first();
            if ($creator) {
                $rank = Player::where('power', '>', $creator->power)->count();
                $rank += Player::where('power', $creator->power)->where('id', '<', $creator->id)->count();
                $rank++;
                $game['creator']['rank'] = $rank;
            }
        }
        return $game;
    }
    public function getGame(Request $request, $url)
    {
        if ($request->session()->has('isGuest')) {
            try {
                $player = $request->session()->get('userSession');
                $game = GuestGame::query()->where('url', $url)->first();
                if (!$game) {
                    $game = Game::query()->where('url', $url)->first();
                    if ($game->status === "pending") {
                        $newGame = GuestGame::create([
                            'creator' => $game->creator->wallet_address,
                            'opponent' => $player,
                            'url' => $game->url,
                            'status' => 'started',
                            'state' => $game->state,
                        ]);
                        $game->delete();
                        $address = $newGame->creator;
                        if ($newGame->creator !== $player) {
                            $creator = Player::where('wallet_address', $newGame->creator)->first();
                            if ($creator !== null) {
                                $newGame['opponent'] = ['wallet_address' => $newGame->opponent];
                                $newGame['creator'] = [
                                    'wallet_address' => $creator->wallet_address,
                                    'color_id' => $creator->color_id];
                            } else {
                                $newGame['opponent'] = ['wallet_address' => $newGame->opponent];
                                $newGame['creator'] = ['wallet_address' => $newGame->creator];
                            }
                        } else {
                            $newGame['opponent'] = ['wallet_address' => $newGame->opponent];
                            $newGame['creator'] = ['wallet_address' => $newGame->creator];
                        }
                        event(new ConnectGame($address));
                        $newGame = $this->setRanks($newGame);
                        return response()->json(['message' => 'success', 'game' => $newGame]);
                    }
                } else {
                    $player = $request->session()->get('userSession');
                    if ($game->status === "started" && !($player === $game->creator || $player === $game->opponent)) {
                        return response()->json(['message' => 'Bed request'], 400);
                    }
                    if ($game->status === "pending" && $game->creator !== $player) {
                        $game->update([
                            'opponent' => $player,
                            'status' => 'started'
                        ]);
                        $game['opponent'] = ['wallet_address' => $game->opponent];
                        $game = GuestGame::query()->where('url', $url)->first();
                        event(new ConnectGame($game->creator));
                    }
                    if ($game->opponent) {
                        if ($game->opponent === $player) {
                            $creator = Player::where('wallet_address', $game->creator)->first();
                            if ($creator !== null) {
                                $game['opponent'] = ['wallet_address' => $game->opponent];
                                $game['creator'] = ['wallet_address' => $game->creator,
                                    'color_id' => $creator->color_id];
                            } else {
                                $game['opponent'] = ['wallet_address' => $game->opponent];
                                $game['creator'] = ['wallet_address' => $game->creator];
                            }
                        } else {
                            $opponent = Player::where('wallet_address', $game->opponent)->first();
                            if ($opponent !== null) {
                                $game['opponent'] = ['wallet_address' => $game->opponent,
                                    'color_id' => $opponent->color_id];
                                $game['creator'] = ['wallet_address' => $game->creator];
                            } else {
                                $game['opponent'] = ['wallet_address' => $game->opponent];
                                $game['creator'] = ['wallet_address' => $game->creator];
                            }
                        }
                    } else {
                        $game['opponent'] = ['wallet_address' => $game->opponent];
                        $game['creator'] = ['wallet_address' => $game->creator];
                    }
                    $game = $this->setRanks($game);
                    return response()->json(['message' => 'success', 'game' => $game]);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Bed request'], 400);
            }

        } else {
            $game = Game::query()->where('url', $url)->with(['opponent', 'creator'])->first();
            $player = Player::where('wallet_address', $request->address)->first();
        }
        if (!$player) {
            return response()->json(['message' => 'Bed request'], 400);
        }
        if (!$game) {
            $game = GuestGame::query()->where('url', $url)->first();
            if (!$game) return response()->json(['message' => 'Not Found'], 404);
            if ($game->status === "started" && !($player->wallet_address === $game->creator || $player->wallet_address === $game->opponent)) {
                return response()->json(['message' => 'Bed request'], 400);
            }
            if ($game->status === "pending") {
                $game->update([
                    'opponent' => $player->wallet_address,
                    'status' => 'started'
                ]);
                $game = GuestGame::query()->where('url', $url)->first();
                $creator = $game->creator;
                if ($player->wallet_address === $game->creator) {
                    $game['opponent'] = ['wallet_address' => $game->opponent];
                    $game['creator'] = ['wallet_address' => $game->creator,
                        'color_id' => $player->color_id];
                }
                if ($player->wallet_address === $game->opponent) {
                    $game['opponent'] = ['wallet_address' => $game->opponent,
                        'color_id' => $player->color_id];
                    $game['creator'] = ['wallet_address' => $game->creator];
                }
                event(new ConnectGame($creator));
                $game = $this->setRanks($game);
                return response()->json(['message' => 'success', 'game' => $game]);
            }
            if ($player->wallet_address === $game->creator) {
                $game['opponent'] = ['wallet_address' => $game->opponent];
                $game['creator'] = ['wallet_address' => $game->creator,
                    'color_id' => $player->color_id];
            }
            if ($player->wallet_address === $game->opponent) {
                $game['opponent'] = ['wallet_address' => $game->opponent,
                    'color_id' => $player->color_id];
                $game['creator'] = ['wallet_address' => $game->creator];
            }
            $game = $this->setRanks($game);
            return response()->json(['message' => 'success', 'game' => $game]);

        }
        if ($game->status === "started" && !($player->id === $game->creator_id || $player->id === $game->opponent_id)) {
            return response()->json(['message' => 'Bed request'], 400);
        }
        if ($game->status === "pending" && $game->creator_id !== $player->id) {
            $game->update([
                'opponent_id' => $player->id,
                'status' => 'started'
            ]);
            $game = Game::query()->where('url', $url)->with(['opponent', 'creator'])->first();

            event(new ConnectGame($game->creator->wallet_address));
        }
        $game = $this->setRanks($game);
        return response()->json(['message' => 'success', 'game' => $game]);
    }
    public function setState(Request $request)
    {
        $id = $request->id;
        if ($request->session()->has('isGuest')) {
            $game = GuestGame::where('url', $id)->first();
            if ($game->opponent) {
                $turn = $request->address === $game->opponent ? "white" : "black";
                $game->state = ['state' => $request->state, 'turn' => $turn, 'colors' => $request->colors];
                $game->save();
                event(new DoStep(
                    $game,
                    $request->address === $game->opponent ? $game->creator : $game->opponent,
                    $request->lastMove
                ));
            } else {
                $turn = $request->turn;
                $game->state = ['state' => $request->state, 'turn' => $turn, 'colors' => $request->colors];
                $game->save();
            }
        } else {
            $game = Game::where('url', $id)->first();
            if ($game) {
                if ($game->opponent_id && $game->opponent->wallet_address) {
                    $turn = $request->address === $game->opponent->wallet_address ? "white" : "black";
                    $game->state = ['state' => $request->state, 'turn' => $turn, 'colors' => $request->colors];
                    $game->save();
                    if ($game->opponent->wallet_address)
                        event(new DoStep(
                            $game,
                            $request->address === $game->opponent->wallet_address ? $game->creator->wallet_address : $game->opponent->wallet_address,
                            $request->lastMove
                        ));
                } else {
                    $turn = $request->turn;
                    $game->state = ['state' => $request->state, 'turn' => $turn, 'colors' => $request->colors];
                    $game->save();
                }
            } else {
                $game = GuestGame::where('url', $id)->first();
                $turn = $request->address === $game->opponent ? "white" : "black";
                $game->state = ['state' => $request->state, 'turn' => $turn, 'colors' => $request->colors];
                $game->save();
                event(new DoStep(
                    $game,
                    $request->address === $game->opponent ? $game->creator : $game->opponent,
                    $request->lastMove
                ));
            }
        }
        return response()->json([
            'data' => $request->all(),
            'game' => $game
        ]);
    }
    public function deleteGame(Request $request, $url)
    {
        $game = GuestGame::query()->where('url', $url)->first();
        if (!$game) {
            $game = Game::query()->where('url', $url)->first();
            if (!$game) {
                return response()->json(['message' => 'Not Found'], 404);
            }
        }
        if (!$game->opponent) {
            $game->delete();
        }
        return response()->json(['message' => 'deleted']);
    }
    public function finishedGame(Request $request)
    {
        $game_id = $request->game_id;
        $player = $request->player;
        $win = $request->win;
        $type = $request->type;
        if ($request->session()->has('isGuest')) {
            $game = GuestGame::where('url', $game_id)->where('status', 'started')->first();
            if (!$game) {
                return response()->json(['message' => 'Bed request'], 400);
            }
            $game->update([
                'status' => "finished"
            ]);
            $winner_address = $game->creator;
            if ($player === $game->creator) {
                $winner_address = $game->opponent;
            }
            if ($player === $game->opponent) {
                $winner_address = $game->creator;
            }
            if ($player !== $game->opponent) {
                $winner_address = $game->opponent;
            }
            if ($type) {
                event(new QuitGame($winner_address));
            }
            return response()->json(['message' => 'finished']);
        }
        $game = Game::where('url', $game_id)->where('status', 'started')->first();
        $finishedGame = Game::where('url', $game_id)->where('status', 'finished')->first();
        if ($finishedGame) {
            return response()->json(['message' => 'finished']);
        }
        if (!$game) {
            $game = GuestGame::where('url', $game_id)->where('status', 'started')->first();
            if (!$game) {
                return response()->json(['message' => 'Bed request'], 400);
            }
            $game->update([
                'status' => "finished"
            ]);
            $winner_address = $game->creator;
            if ($player === $game->creator) {
                $winner_address = $game->opponent;
            }
            if ($player === $game->opponent) {
                $winner_address = $game->creator;
            }
            if ($type) {
                event(new QuitGame($winner_address));
            }
            return response()->json(['message' => $game]);
        }
        if ($player === $game->creator->wallet_address || $player === $game->opponent->wallet_address) {
            $user = Player::query()->where('wallet_address', $player)->first();

            if ($game->opponent) {
                if ($win === 'white') {
                    if ($user->wallet_address === $game->creator->wallet_address) {
                        $winner = $game->creator;
                        $loser = $game->opponent;
                    } else {
                        $winner = $game->opponent;
                        $loser = $game->creator;
                    }
                } else {
                    if ($user->wallet_address === $game->creator->wallet_address) {
                        $winner = $game->opponent;
                        $loser = $game->creator;
                    } else {
                        $winner = $game->creator;
                        $loser = $game->opponent;
                    }
                }
                $winner->update([
                    "power" => $winner->power + 3,
                    'wins' => $winner->wins + 1
                ]);
                $loser->update([
                    "power" => $loser->power + 1
                ]);
                if ($type) {
                    $winner_address = $winner->wallet_address;
                    event(new QuitGame($winner_address));
                }
            } else {
                if ($win) {
                    $user->update([
                        "power" => $user->power + 3,
                        'wins' => $user->wins + 1
                    ]);
                } else {
                    $user->update([
                        "power" => $user->power + 0
                    ]);
                }
            }
            $game->update([
                'status' => "finished"
            ]);
            return response()->json(['message' => 'finished']);
        } else {
            return response()->json(['message' => 'Bed request'], 400);
        }

    }
    public function getActiveGameMode(Request $request)
    {
        return response()->json(['game_mode' => GameMode::select('level')->where('active', true)->first()]);
    }
}

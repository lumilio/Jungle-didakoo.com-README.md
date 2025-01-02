<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Elliptic\EC;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use kornrunner\Keccak;
use App\Player;
class Web3LoginController extends Controller
{
    public function message(): string
    {
        $nonce = Str::random();
        $message = "Sign this message to confirm you own this wallet address. This action will not cost any gas fees.\n\nNonce: " . $nonce;
        return $message;
    }
    public function verify(Request $request): string
    {
        $result = $this->verifySignature($request->input('message'), $request->input('signature'), $request->input('address'));
        $player_wallet_details = DB::table('players')->where('wallet_address', $request->input('address'))->first();
        if($player_wallet_details)
        {
            $request->session()->put('userSession', $player_wallet_details->wallet_address);
        }
        if($result == true) {
            $request->session()->put('loggedIn', 'success');
        }
        return ($result ? 'OK' : 'ERROR');
    }
    protected function verifySignature(string $message, string $signature, string $address): bool
    {
        $hash = Keccak::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message), 256);
        $sign = [
            'r' => substr($signature, 2, 64),
            's' => substr($signature, 66, 64),
        ];
        $recid = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recid != ($recid & 1)) {
            return false;
        }
        $pubkey = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recid);
        $derived_address = '0x' . substr(Keccak::hash(substr(hex2bin($pubkey->encode('hex')), 1), 256), 24);
        return (Str::lower($address) === $derived_address);
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'wallet_address'     => 'required|min:42|max:42|unique:players',
            'balance'           => 'required|string|min:2|max:255',
            'alias'             => 'required|string|min:3|max:255'
        ]);
        $player = Player::create([
            'wallet_address'    => $validatedData['wallet_address'],
            'balance'           => $validatedData['balance'],
            'alias'             => $validatedData['alias'],
        ]);
        $request->session()->put('userSession', $player->wallet_address);
        return "SUCCESS";
    }
    /**
     * @throws \Exception
     */
    public function update(Request $request)
    {
        $data = $request->input();
        $ethwalletaddr = $data['ethwalletaddr'];
        $balance = $data['balance'];
        DB::update('update players set balance = ? where wallet_address = ?',[$balance, $ethwalletaddr]);
        $player_wallet_details = DB::table('players')->where('wallet_address', $ethwalletaddr)->first();
        if($player_wallet_details)
        {
            $request->session()->put('userSession', $ethwalletaddr);
        }
        return "SUCCESS";
    }
    public function getSession(Request $request)
    {
        if ($request->session()->has('loggedIn')){
            if ($request->session()->has('isGuest')){
                return response()->json([
                    'address' => $request->session()->get('userSession'),
                    'color' => 1,
                    'power' => 0
                ]);
            }
            $player = Player::query()->where('wallet_address', $request->session()->get('userSession'))->first();
            if ($player)
            return response()->json([
                'address' => $player->wallet_address,
                'color' => $player->color_id,
                'power' =>$player->power ,
                'id' =>$player->id ,
            ]);
        }
        return 'failed';
    }
    public function updatePlayerLastActivity(Request $request)
    {
        $player = Player::query()->where('wallet_address', $request->session()->get('userSession'))->first();
        if (!$player){
            if ($request->session()->has('isGuest')){
                return response()->json([
                    'address' => $request->session()->get('userSession'),
                    'color' => 1,
                    'power' => 0
                ]);
            } else{
                return response()->json([
                    'message' => 'No player found'
                ], 404);
            }
        }
        $player->last_activity = now('UTC');
        $player->save();
        return response()->json([
            'address' => $player->wallet_address,
            'color' => $player->color_id,
            'power' => $player->power,
            'id' => $player->id,
            'last_activity' => $player->last_activity
        ]);
    }
    public function logout(Request $request)
    {
        $request->session()->forget(['loggedIn','userSession', 'isGuest']);
        return true;
    }
    public function getUsers()
    {
        $players = Player::all()->toArray();
        echo json_encode(['playersData'=>$players]);
    }
    public function IfThereNft(Request $request)
    {
        $Nft_1_sunflower_1 = $request->sunFlower_1;
        $Nft_2_jungle_1 = $request->nft_2_jungle_1;
        $Nft_2_jungle_mega = $request->nft_2_jungle_mega ? : 0;
        $Nft_2_jungle_1_base = $request->nft_2_jungle_1_base ? : 0;
        $Nft_2_jungle_1_polygon = $request->nft_2_jungle_1_polygon ? : 0;
        $Nft_3_battery = $request->nft_3_battery;
        $Nft_4_color1 = $request->nft_4_color1;
        $Nft_5_color2 = $request->nft_5_color2;
        $Nft_6_color3 = $request->nft_6_color3;
        $Nft_7_color4 = $request->nft_7_color4;
        $Nft_8_bot1 = $request->nft_8_bot1;
        $Nft_8_bot2 = $request->nft_8_bot2;
        $Nft_21_raygun = $request->nft_21_raygun;
        $Nft_22_leo_1 = $request->nft_22_leo_1;
        $Nft_23_leo_2 = $request->nft_23_leo_2;
        $Nft_24_leo_3 = $request->nft_24_leo_3;
        $player = $request->player;
        $color = [];
        $creator = Player::query()->where('wallet_address', $player)->first();
        if (!$creator) {
            return response()->json(['message' => 'User not found'], 404);
        } else {
            if ($Nft_1_sunflower_1 !== $creator->nft_1_sunflower_1) {
                $power = $creator->power + ($Nft_1_sunflower_1 - $creator->nft_1_sunflower_1) * 10;
                $creator->nft_1_sunflower_1 = $Nft_1_sunflower_1;
                $creator->power = $power;
            }
            if ($Nft_2_jungle_1 !== $creator->nft_2_jungle_1) {
                $power = $creator->power + ($Nft_2_jungle_1 - $creator->nft_2_jungle_1) * 5;
                $creator->nft_2_jungle_1 = $Nft_2_jungle_1;
                $creator->power = $power;
            }
            if ($Nft_2_jungle_mega !== $creator->nft_2_jungle_mega) {
                $power = $creator->power + ($Nft_2_jungle_mega - $creator->nft_2_jungle_mega) * 5000;
                $creator->nft_2_jungle_mega = $Nft_2_jungle_mega;
                $creator->power = $power;
            }
            if ($Nft_2_jungle_1_base !== $creator->nft_2_jungle_1_base) {
                $power = $creator->power + ($Nft_2_jungle_1_base - $creator->nft_2_jungle_1_base) * 5;
                $creator->nft_2_jungle_1_base = $Nft_2_jungle_1_base;
                $creator->power = $power;
            }
            if ($Nft_2_jungle_1_polygon !== $creator->nft_2_jungle_1_polygon) {
                $power = $creator->power + ($Nft_2_jungle_1_polygon - $creator->nft_2_jungle_1_polygon) * 5;
                $creator->nft_2_jungle_1_polygon = $Nft_2_jungle_1_polygon;
                $creator->power = $power;
            }
            if ($Nft_3_battery !== $creator->nft_3_battery) {
                $power = $creator->power + ($Nft_3_battery - $creator->nft_3_battery) * 5000;
                $creator->nft_3_battery = $Nft_3_battery;
                $creator->power = $power;
            }
            $creator->save();
            if ($Nft_4_color1) {
                $color[] = 1;
            }
            if ($Nft_5_color2) {
                $color[] = 2;
            }
            if ($Nft_6_color3) {
                $color[] = 3;
            }
            if ($Nft_7_color4) {
                $color[] = 4;
            }
            if (count($color) !== 0){
                $color_id = $color[rand(0, count($color) - 1)];
                $creator->update(['color_id' => $color_id]);
            }else{
                if($creator->color_id === 0){
                    $color_id = rand(1, 4);
                    $creator->update(['color_id' => $color_id]);
                }
            }
            $creator->update([
                'nft_4_color1' => !!$Nft_4_color1,
                'nft_5_color2' => !!$Nft_5_color2,
                'nft_6_color3' => !!$Nft_6_color3,
                'nft_7_color4' => !!$Nft_7_color4,
                'nft_8_bot' => max(!!$Nft_8_bot1, !!$Nft_8_bot2),
                'nft_21_raygun' => !!$Nft_21_raygun,
                'nft_22_leo_1' => !!$Nft_22_leo_1,
                'nft_23_leo_2' => !!$Nft_23_leo_2,
                'nft_24_leo_3' => !!$Nft_24_leo_3,
            ]);
        }
    }
    public function NftCollection(Request $request) {
        $Nft_9_cat = $request->nft_9_cat;
        $Nft_10_monkey1 = $request->nft_10_monkey1;
        $Nft_10_monkey2 = $request->nft_10_monkey2;
        $Nft_11_punks = $request->nft_11_punks;
        $Nft_12_monster = $request->nft_12_monster;
        $Nft_13_doodle = $request->nft_13_doodle;
        $Nft_14_sandbox1 = $request->nft_14_sandbox1;
        $Nft_14_sandbox2 = $request->nft_14_sandbox2;
        $Nft_15_totem = $request->nft_15_totem;
        $Nft_16_nike = $request->nft_16_nike;
        $Nft_17_adidas = $request->nft_17_adidas;
        $Nft_18_pepsi = $request->nft_18_pepsi;
        $Nft_19_lacoste = $request->nft_19_lacoste;
        $Nft_20_land = $request->nft_20_land;
        $player = $request->player;
        $creator = Player::query()->where('wallet_address', $player)->first();
        if (!$creator) {
            return response()->json(['message' => 'User not found'], 404);
        } else {
            $creator->update([
                'nft_9_cat' => !!$Nft_9_cat,
                'nft_10_monkey' => max(!!$Nft_10_monkey1,!!$Nft_10_monkey2),
                'nft_11_punks' => !!$Nft_11_punks,
                'nft_12_monster' => !!$Nft_12_monster,
                'nft_13_doodle' => !!$Nft_13_doodle,
                'nft_14_sandbox' => max(!!$Nft_14_sandbox1,!!$Nft_14_sandbox2),
                'nft_15_totem' => !!$Nft_15_totem,
                'nft_16_nike' => !!$Nft_16_nike,
                'nft_17_adidas' => !!$Nft_17_adidas,
                'nft_18_pepsi' => !!$Nft_18_pepsi,
                'nft_19_lacoste' => !!$Nft_19_lacoste,
                'nft_20_land' => !!$Nft_20_land,
            ]);
        }
    }
    public function loginAsGuest(Request $request){
        try {
            $id = Str::random(30);
            $request->session()->put('userSession', $id);
            $request->session()->put('isGuest', true);
            $request->session()->put('loggedIn', 'success');
            return response()->json(['message' => 'Success', 'address' => $id]);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}

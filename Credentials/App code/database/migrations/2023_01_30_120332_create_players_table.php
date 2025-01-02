<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_address')->unique();
            $table->integer('power')->default(0);
            $table->integer('color_id')->default(0);
            $table->boolean('room_openn_flag')->default(0);
            $table->integer('money')->default(0);
            $table->integer('wins')->default(0);
            $table->integer('nft_1_sunflower_1')->default(0);
            $table->integer('nft_2_sunflower_2')->default(0);
            $table->integer('nft_3_battery')->default(0);
            $table->boolean('nft_4_color1')->default(0);
            $table->boolean('nft_5_color2')->default(0);
            $table->boolean('nft_6_color3')->default(0);
            $table->boolean('nft_7_color4')->default(0);
            $table->boolean('nft_8_bot')->default(0);
            $table->boolean('nft_21_raygun')->default(0);
            $table->boolean('nft_9_cat')->default(0);
            $table->boolean('nft_10_monkey')->default(0);
            $table->boolean('nft_11_punks')->default(0);
            $table->boolean('nft_12_monster')->default(0);
            $table->boolean('nft_13_doodle')->default(0);
            $table->boolean('nft_14_sandbox')->default(0);
            $table->boolean('nft_15_totem')->default(0);
            $table->boolean('nft_16_nike')->default(0);
            $table->boolean('nft_17_adidas')->default(0);
            $table->boolean('nft_18_pepsi')->default(0);
            $table->boolean('nft_19_lacoste')->default(0);
            $table->boolean('nft_20_land')->default(0);
            // $table->boolean('nft_21_raygun');
            $table->boolean('nft_22_leo_1')->default(0);
            $table->boolean('nft_23_leo_2')->default(0);
            $table->boolean('nft_24_leo_3')->default(0);
            $table->boolean('nft_25_wb')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}

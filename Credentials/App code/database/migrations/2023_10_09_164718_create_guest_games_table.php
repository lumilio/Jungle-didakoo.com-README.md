<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_games', function (Blueprint $table) {
            $table->id();
            $table->string('creator')->nullable();
            $table->string('opponent')->nullable();
            $table->string('url')->nullable();
            $table->string('status')->nullable();
            $table->json('state')->nullable();
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
        Schema::dropIfExists('guest_games');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverCardCarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_car', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id');
            $table->integer('car_id');
            $table->integer('customer_id');
            $table->integer('user_id');
            $table->string('status', 15);
            $table->string('token', 100);
            $table->string('type_command', 45);
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
        Schema::dropIfExists('driver_card_car');
    }
}

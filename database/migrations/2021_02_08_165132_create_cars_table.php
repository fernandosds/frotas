<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     * Placa, chassi, modelo, marca, ano, cor, tipo (caminhão, passeio, etc...)
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('placa', 9);
            $table->string('chassi', 25);
            $table->string('model', 255);
            $table->string('automaker', 50);
            $table->year('year');
            $table->string('color', 20);
            $table->string('type', 15);
            $table->softDeletes();
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
        Schema::dropIfExists('cars');
    }
}

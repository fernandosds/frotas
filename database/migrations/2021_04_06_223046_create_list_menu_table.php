<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('list_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('user_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('list_menu_id')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO list_menu (id, name, description) VALUES (1, 'monitoring', 'Menu de monitoramento');");
        DB::statement("INSERT INTO list_menu (id, name, description) VALUES (2, 'dashboard', 'Menu de dashboard');");
        DB::statement("INSERT INTO list_menu (id, name, description) VALUES (3, 'driver', 'Menu de motorista');");
        DB::statement("INSERT INTO list_menu (id, name, description) VALUES (4, 'fleet_car', 'Menu de frotas de carros');");
        DB::statement("INSERT INTO list_menu (id, name, description) VALUES (5, 'card', 'Menu de cartões');");
        DB::statement("INSERT INTO list_menu (id, name, description) VALUES (6, 'cost', 'Menu de custos');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_menu');
    }
}

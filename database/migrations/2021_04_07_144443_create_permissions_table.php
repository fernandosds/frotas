<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->unsignedInteger('monitoring_id')->nullable();
            $table->unsignedInteger('dashboard_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('fleet_car_id')->nullable();
            $table->unsignedInteger('card_id')->nullable();
            $table->unsignedInteger('cost_id')->nullable();
            $table->timestamps();
            $table->softDeletes();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsTablePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('type');            
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('car_id')->nullable();
            $table->unsignedInteger('card_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();

        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->enum('type', ['administrador', 'usuario']);
            $table->dropColumn('user_id');
            $table->dropColumn('car_id');
            $table->dropColumn('card_id');
            $table->dropColumn('driver_id');
        });
    }
}

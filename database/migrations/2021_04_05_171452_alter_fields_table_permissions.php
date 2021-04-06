<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFieldsTablePermissions extends Migration
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
            $table->integer('user_id')->after('id');
            $table->unsignedInteger('monitoring')->after('user_id')->default(1);
            $table->unsignedInteger('dashboard')->after('monitoring')->default(1);
            $table->unsignedInteger('driver')->after('dashboard')->default(1);
            $table->unsignedInteger('fleet_car')->after('driver')->default(1);
            $table->unsignedInteger('card')->after('fleet_car')->default(1);
            $table->unsignedInteger('cost')->after('card')->default(1);            

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
            $table->dropColumn('monitoring');
            $table->dropColumn('dashboard');
            $table->dropColumn('driver');
            $table->dropColumn('fleet_car');
            $table->dropColumn('card');
            $table->dropColumn('cost');
        });
    }
}

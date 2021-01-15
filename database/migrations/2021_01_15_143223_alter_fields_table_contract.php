<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFieldsTableContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['log_id', 'shipment_id', 'device_type']);
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->integer('log_id');
            $table->integer('shipment_id');
            $table->enum('device_type', ['Retornavel', 'Descartavel']);
            $table->dropColumn('user_id');
        });
    }
}

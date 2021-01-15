<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFieldsTableDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {            
            $table->string('uniqid', 50);
            $table->integer('contract_id')->after('uniqid');
            $table->integer('customer_id')->after('contract_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {            
            $table->dropColumn(['uniqid','contract_id', 'customer_id']);
        });
    }
}

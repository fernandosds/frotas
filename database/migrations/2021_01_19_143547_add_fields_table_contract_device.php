<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsTableContractDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_devices', function (Blueprint $table) {
            $table->integer('quantity');
            $table->integer('technologie_id');
            $table->decimal('unitary_value', 8, 2);
            $table->decimal('total_value', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_devices', function (Blueprint $table) {
            $table->dropColumn([
                'quantity',
                'technologie_id',
                'unitary_value',
                'total_value'
            ]);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPairDeviceTrackerActiveTrackerFieldTableBoardings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boardings', function (Blueprint $table) {
            $table->string('pair_device_tracker', 50)->nullable()->after('active');
            $table->boolean('active_tracker')->default(0)->after('pair_device_tracker');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boardings', function (Blueprint $table) {
            $table->dropColumn('pair_device_tracker');
            $table->dropColumn('active_tracker');
        });
    }
}

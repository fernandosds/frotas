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
            $table->string('attatch_device', 50)->nullable()->after('pair_device');
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
            $table->dropColumn('attatch_device');
        });
    }
}

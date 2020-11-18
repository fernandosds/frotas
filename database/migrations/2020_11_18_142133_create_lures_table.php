<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lures', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id');
            $table->string('serial_number', 255);
            $table->string('batery_level', 255);
            $table->string('name', 255);
            $table->date('validation');
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
        Schema::dropIfExists('lures');
    }
}

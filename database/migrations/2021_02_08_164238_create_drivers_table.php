<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('name', 255);
            $table->string('cpf', 18);
            $table->string('cnh', 11);
            $table->string('address', 255);
            $table->string('phone', 20)->nullable();  
            $table->string('email', 100)->nullable();
            $table->boolean('status')->default(0);
            $table->softDeletes(); 
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
        Schema::dropIfExists('drivers');
    }
}

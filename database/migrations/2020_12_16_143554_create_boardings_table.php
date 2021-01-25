<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boardings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('customer_id');
            $table->integer('contract_id');
            $table->integer('type_of_load_id');
            $table->integer('device_id');
            $table->integer('accommodation_location_id');
            $table->string('source', 255);
            $table->string('destiny', 255);
            $table->string('transporter', 255);
            $table->string('telephone', 255);
            $table->string('board', 255);
            $table->string('chassis', 255);
            $table->string('carts_plates', 255);
            $table->string('transport_order', 255);
            $table->string('amount_carried', 255);
            $table->string('cpf_cnpj', 255);
            $table->string('cell_phone', 255)->nullable();
            $table->string('brand', 255);
            $table->string('model', 255);
            $table->string('redundant_technologie', 255);
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('boardings');
    }
}

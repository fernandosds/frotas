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
            $table->integer('type_of_load_id')->nullable();
            $table->integer('device_id');
            $table->integer('duration')->nullable();
            $table->integer('accommodation_location_id')->nullable();
            $table->string('source', 255)->nullable();
            $table->string('destiny', 255)->nullable();
            $table->string('transporter', 255)->nullable();
            $table->string('telephone', 255)->nullable();
            $table->string('board', 255)->nullable();
            $table->string('chassis', 255)->nullable();
            $table->string('transport_order', 255)->nullable();
            $table->string('amount_carried', 255)->nullable();
            $table->string('cpf_cnpj', 255)->nullable();
            $table->string('cell_phone', 255)->nullable();
            $table->string('brand', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('pair_device', 50)->nullable();
            $table->boolean('active')->default(0);
            $table->dateTime('finished_at')->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustormersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('cpf_cnpj', 18)->nullable();
            $table->enum('type', ['embarcado', 'transportadora', 'cliente'])->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('complement', 255)->nullable();
            $table->string('number', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('neighborhood', 255)->nullable();
            $table->string('state', 255)->nullable();
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
        Schema::dropIfExists('customers');
    }
}

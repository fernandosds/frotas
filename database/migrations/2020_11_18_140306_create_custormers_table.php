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

        Schema::create('custormers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('cpf_cnpj', 18);
            $table->enum('type', ['Embarcado', 'Transportadora', 'Cliente']);
            $table->string('cep', 9);
            $table->string('address', 255);
            $table->string('complement', 255);
            $table->string('number', 100);
            $table->string('city', 100);
            $table->string('neighborhood', 255);
            $table->string('state', 255);
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
        Schema::dropIfExists('custormers');
    }
}

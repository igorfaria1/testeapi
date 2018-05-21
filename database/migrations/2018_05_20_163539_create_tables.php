<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabela de Locais
        Schema::create('locais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('logradouro');
            $table->string('cep', 8);
            $table->string('estado', 2);
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabela de Eventos
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->string('titulo');
            $table->string('descricao');
            $table->date('data');
            $table->unsignedInteger('local_id');
            $table->foreign('local_id')
                    ->references('id')
                    ->on('locais')
                    ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
        Schema::dropIfExists('locais');
    }
}

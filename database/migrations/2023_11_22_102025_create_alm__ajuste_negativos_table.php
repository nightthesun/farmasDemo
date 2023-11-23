<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alm__ajuste_negativos', function (Blueprint $table) {
            $table->id();
            $table->smallInteger("id_usuario")->comment("id del usuario que realizo la asignacion");
            $table->string("usuario")->comment("nombre de usuario que hizo la operacion");
            $table->string("codigo")->comment("Codigo del producto que es asignado por el sistema");
            $table->string("linea")->comment("tipo de linea del producto");
            $table->string("producto")->comment("nombre del producto");
            $table->string("cantidad")->comment("stock del producto que se esta ingresando por el input");
            $table->string("tipo")->comment("es el tipo de entrada");
            $table->string("descripcion")->comment("son datos de entrada del formulario");
            $table->date("fecha")->comment("fecha que se realizo el registro");
            $table->boolean("estado")->default(1);
            $table->smallInteger('id_usuario_modifica')->unsigned()->nullable()->comment('identificador del usuario que esta modificando el almacen');
            $table->smallInteger('id_usuario_registra')->unsigned()->nullable()->comment('identificador del usuario que esta registrando el almacen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alm__ajuste_negativos');
    }
};

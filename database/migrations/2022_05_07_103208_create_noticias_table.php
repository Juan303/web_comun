<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias_noticias', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->text('Titulo');
            $table->text('Slug')->unique();
            $table->string('Imagen')->nullable();
            $table->boolean('Estado')->default(true);
            $table->timestamps();
        });

        Schema::create('noticias', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->text('Titulo');
            $table->text('Slug')->unique();
            $table->text('Texto')->nullable();
            $table->string('Imagen')->nullable();
            $table->timestamp('FechaInicio')->useCurrent();
            $table->timestamp('FechaFin')->nullable();
            $table->boolean('Estado')->default(true);
            $table->timestamps();

            //FK
            $table->bigInteger('categorias_noticia_id')->unsigned()->nullable();
            $table->foreign('categorias_noticia_id')->references('id')->on('categorias_noticias')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noticias');
        Schema::dropIfExists('categorias_noticias');
    }
}

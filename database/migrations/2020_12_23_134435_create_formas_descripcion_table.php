<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormasDescripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formas_descripcion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forma_evaluacion_id')->constrained('formas_evaluacion')->onDelete('cascade');
            $table->string('opcion');
            $table->boolean('aprobado');
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
        Schema::dropIfExists('formas_descripcion');
    }
}

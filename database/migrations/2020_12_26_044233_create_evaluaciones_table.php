<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->foreignId('division_id')->constrained('divisiones')->onDelete('cascade');
            $table->foreignId('asignatura_id')->constrained('asignaturas')->onDelete('cascade');
            $table->string('titulo');
            $table->string('tipo');
            $table->dateTime('fechaHoraRealizacion');
            $table->dateTime('fechaHoraFinalizacion');
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('evaluaciones');
    }
}

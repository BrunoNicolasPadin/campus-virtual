<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->foreignId('nivel_id')->constrained('niveles')->onDelete('cascade');
            $table->foreignId('orientacion_id')->nullable()->constrained('orientaciones')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('division');
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade');
            $table->string('claveDeAcceso');
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
        Schema::dropIfExists('divisiones');
    }
}

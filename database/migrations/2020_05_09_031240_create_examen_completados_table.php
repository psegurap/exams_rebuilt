<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamenCompletadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examenes_completados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('template_id');
            $table->integer('user_id');
            $table->tinyInteger('status');
            $table->tinyInteger('calificacion_final')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('examenes_completados');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFootfallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footfalls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('hospitalId');
            $table->integer('addedBy');
            $table->integer('patient');
            $table->integer('chemo');
            $table->integer('radiation');
            $table->integer('doctors');
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
        Schema::dropIfExists('footfalls');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hospitalId');
            $table->integer('addedBy');
            $table->string('name');
            $table->string('photo')->nullable();
            $table->longText('short_description');
            $table->longText('long_description');
            $table->longText('description');
            $table->boolean('read_more')->default(0);
            $table->boolean('read_more2')->default(0);
            $table->integer('indexx');
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
        Schema::dropIfExists('facilities');
    }
}

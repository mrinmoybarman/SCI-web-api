<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hospitalId');
            $table->integer('addedBy');
            $table->string('name');
            $table->integer('indexx');
            $table->longText('short_description');
            $table->longText('long_description');
            $table->longText('description');
            $table->boolean('read_more');
            $table->string('photo');
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
        Schema::dropIfExists('about_sections');
    }
}

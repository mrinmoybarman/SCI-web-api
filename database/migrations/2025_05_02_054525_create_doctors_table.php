<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hospitalId');
            $table->integer('addedBy');
            $table->string('name');
            $table->string('designation');
            $table->string('depertment');
            $table->string('qualification');
            $table->string('specialization')->nullable();
            $table->string('achievement')->nullable();
            $table->string('awards')->nullable();
            $table->longText('profile_details');
            $table->string('photo')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('doctors');
    }
}

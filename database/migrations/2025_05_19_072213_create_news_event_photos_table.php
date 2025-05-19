<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsEventPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_event_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('news_event_id');
            $table->string('photo_path');
            $table->timestamps();
            $table->foreign('news_event_id')->references('id')->on('news_and_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_event_photos');
    }
}

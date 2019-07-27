<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_maps', function (Blueprint $table) {
            $table->bigIncrements('classID');
            $table->bigInteger('standardID')->unsigned();
            $table->bigInteger('sectionID')->unsigned();
            $table->foreign('standardID')->references('standardID')->on('standards')->onDelete('cascade');
            $table->foreign('sectionID')->references('sectionID')->on('sections')->onDelete('cascade');
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
        Schema::dropIfExists('class_maps');
    }
}

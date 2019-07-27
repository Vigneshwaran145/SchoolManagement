<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialClassMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_class_maps', function (Blueprint $table) {
            $table->bigIncrements('material_class_id');
            $table->bigInteger('materialID')->unsigned();
            $table->bigInteger('classID')->unsigned();
            $table->timestamps();
            $table->foreign('materialID')->references('materialID')->on('materials')->onDelete('cascade');
            $table->foreign('classID')->references('classID')->on('class_maps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_class_maps');
    }
}

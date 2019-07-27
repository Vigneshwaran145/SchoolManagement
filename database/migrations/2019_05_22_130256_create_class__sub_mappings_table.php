<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassSubMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class__sub_mappings', function (Blueprint $table) {
            $table->bigIncrements('classSubID');
            $table->bigInteger('teacherID')->unsigned();
            $table->bigInteger('subjectID')->unsigned();
            $table->bigInteger('classID')->unsigned();
            $table->foreign('teacherID')->references('teacherID')->on('teachers')->onDelete('cascade');
            $table->foreign('subjectID')->references('subjectID')->on('subjects')->onDelete('cascade');
            $table->foreign('classID')->references('classID')->on('class_maps')->onDelete('cascade');
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
        Schema::dropIfExists('class__sub_mappings');
    }
}

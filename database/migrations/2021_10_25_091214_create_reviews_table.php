<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pros', 1500);
            $table->string('cons', 1500);
            $table->integer('assignment_id')->unsigned();
            $table->integer('mentor_id')->unsigned();
            $table->integer('intern_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assignment_id')->references('id')->on('assignments');
            $table->foreign('mentor_id')->references('id')->on('mentors');
            $table->foreign('intern_id')->references('id')->on('interns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}

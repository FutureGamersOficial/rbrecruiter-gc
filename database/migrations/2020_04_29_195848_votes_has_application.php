<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VotesHasApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes_has_application', function (Blueprint $table){

            $table->id('id');
            $table->bigInteger('vote_id')->unsigned();
            $table->bigInteger('application_id')->unsigned();
            $table->timestamps();

            $table->foreign('vote_id')->references('id')->on('votes');
            $table->foreign('application_id')->references('id')->on('applications');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

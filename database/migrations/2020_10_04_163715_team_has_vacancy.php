<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TeamHasVacancy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_has_vacancy', function(Blueprint $table){

            $table->id();
            $table->integer('team_id')->unsigned();
            $table->bigInteger('vacancy_id')->unsigned();
            $table->timestamps();

            $table->foreign('team_id')
                  ->references('id')
                    ->on(config('teamwork.teams_table'));

            $table->foreign('vacancy_id')
                  ->references('id')
                    ->on('vacancies');

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

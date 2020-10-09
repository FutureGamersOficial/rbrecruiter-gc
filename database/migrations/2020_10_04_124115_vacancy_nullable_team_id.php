<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VacancyNullableTeamId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacancies', function(Blueprint $table){

            $table->dropForeign('vacancies_ownerteamid_foreign');
            $table->dropColumn('ownerTeamID');
            $table->bigInteger('team_id')->nullable()->unsigned();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacancies', function(Blueprint $table){

            $table->dropColumn('team_id');

        });
    }
}

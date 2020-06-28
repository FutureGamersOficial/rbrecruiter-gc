<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('vacancyName');
            $table->longText('vacancyDescription');
            $table->string('permissionGroupName');
            $table->string('discordRoleID');
            $table->unsignedBigInteger('vacancyFormID');
            $table->integer('vacancyCount')->default(3);
            $table->timestamps();

            $table->foreign('vacancyFormID')
                ->references('id')
                ->on('forms');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacancies');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OneoffApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oneoff_applicants', function(Blueprint $table){

            $table->id();
            $table->string('name');
            $table->string('email');
            $table->bigInteger('application_id')->unsigned();
            $table->timestamps();

            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
                
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oneoff_applicants');
    }
}

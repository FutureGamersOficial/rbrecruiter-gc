<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('responseFormID')->unsigned();
            $table->longText('responseData');
            $table->timestamps();

            // A better way would be to link responses directly to vacancies, that subsquently have a form
            $table->foreign('responseFormID')
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
        Schema::dropIfExists('responses');
    }
}

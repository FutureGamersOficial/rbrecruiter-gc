<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('authorID')->unsigned();
            $table->bigInteger('applicationID')->unsigned();
            $table->mediumText('text');
            $table->timestamps();

            $table->foreign('authorID')
                ->references('id')
                ->on('users');

            $table->foreign('applicationID')
                ->references('id')
                ->on('applications');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

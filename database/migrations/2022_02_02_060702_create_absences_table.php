<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('requesterID')->unsigned();
            $table->date('start');
            $table->date('predicted_end');
            $table->boolean('available_assist');
            $table->string('reason');
            $table->enum('status', ['PENDING', 'APPROVED', 'DECLINED', 'CANCELLED', 'ENDED']);
            $table->bigInteger('reviewer')->unsigned()->nullable();
            $table->date('reviewed_date')->nullable();
            $table->timestamps();

            $table->foreign('requesterID')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('reviewer')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absences');
    }
}

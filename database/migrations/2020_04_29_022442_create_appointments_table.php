<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointmentDescription');
            $table->dateTime('appointmentDate');
            $table->bigInteger('applicationID')->unsigned();
            $table->enum('appointmentLocation', [
                'ZOOM',
                'DISCORD',
                'SKYPE',
                'MEET',
                'TEAMSPEAK'
            ]);
            $table->enum('appointmentStatus', [
               'SCHEDULED',
               'CONCLUDED' // TODO: Review whether this status is necessary
            ])->default('SCHEDULED');
            $table->boolean('userAccepted')->default(false);
            $table->longText('meetingNotes')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}

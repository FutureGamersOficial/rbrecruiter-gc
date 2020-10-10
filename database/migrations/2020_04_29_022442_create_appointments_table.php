<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

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
                'TEAMSPEAK',
            ]);
            $table->enum('appointmentStatus', [
                'SCHEDULED',
                'CONCLUDED', // TODO: Review whether this status is necessary
            ])->default('SCHEDULED');
            $table->boolean('userAccepted')->default(false);
            $table->longText('meetingNotes')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('appointments');
    }
}

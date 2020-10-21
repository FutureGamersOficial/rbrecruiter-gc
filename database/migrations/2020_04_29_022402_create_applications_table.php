<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * One user can have one application, and one application can only have one user
         * One form may have multiple responses, but a response may only have one form
         * One application may only have one form response, but a response can have many applications
         */
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('applicantUserID')->unsigned(); // 1-1
            $table->bigInteger('applicantFormResponseID')->unsigned(); // 1-*
            $table->enum('applicationStatus', [
                'STAGE_SUBMITTED',
                'STAGE_PEERAPPROVAL',
                'STAGE_INTERVIEW',
                'STAGE_INTERVIEW_SCHEDULED',
                'APPROVED',
                'DENIED'
            ])->default('STAGE_SUBMITTED');
            $table->timestamps();

            $table->foreign('applicantUserID')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}

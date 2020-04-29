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
            $table->bigIncrements('applicantUserID'); // 1-1
            $table->bigIncrements('applicantFormResponseID'); // 1-*
            $table->enum('applicationStatus', [
                'STAGE_SUBMITTED',
                'STAGE_PEERAPPROVAL',
                'STAGE_INTERVIEW',
                'APPROVED',
                'DENIED'
            ]);
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
        Schema::dropIfExists('applications');
    }
}

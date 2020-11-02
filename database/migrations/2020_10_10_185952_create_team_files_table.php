<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uploaded_by')->unsigned()->index();
            $table->integer('team_id')->unsigned()->index();
            $table->string('name');
            $table->string('fs_location'); // filesystem location
            $table->string('extension');
            $table->timestamps();

            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_files');
    }
}

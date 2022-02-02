<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appellant_id')->unsigned();
            $table->bigInteger('appeal_assignee')->unsigned();
            $table->enum('appeal_type', [
                'discord_ban',
                'discord_timeout'
            ]);
            $table->text('appeal_reasoning_desc');
            $table->enum('appeal_status', [
                'IN_REVISION',
                'AWAITING_DECISION',
                'PUNISHMENT_LIFTED',
                'PUNISHMENT_REDUCED',
                'PUNISHMENT_MAINTAINED'
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
        Schema::dropIfExists('appeals');
    }
}

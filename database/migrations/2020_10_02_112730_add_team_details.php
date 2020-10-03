<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('teamwork.teams_table'), function(Blueprint $table){
            
            $table->text('description')->after('name')->nullable();
            $table->enum('status', ['ACTIVE','SUSPENDED'])->after('description');
            $table->boolean('openJoin')->default(false)->after('status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('teamwork.teams_table'), function(Blueprint $table){

            $table->dropColumn('description');
            $table->dropColumn('status');
            $table->dropColumn('openJoin');

        });
    }
}

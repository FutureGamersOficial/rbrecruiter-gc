<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToTeamFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('team_files', function (Blueprint $table) {
            $table->integer('size')->nullable()->after('extension');
            $table->string('caption')->nullable()->after('name');
            $table->mediumText('description')->nullable()->after('caption');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_files', function (Blueprint $table) {
            $table->dropColumn('size');
            $table->dropColumn('caption');
            $table->dropColumn('description');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordLastUpdatedToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('password_last_updated')->after('remember_token')->nullable();
            $table->boolean('administratively_locked')->after('email')->default(false)->comment('Account locked by settings changes, e.g. 2fa grace period timeout');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password_last_updated');
            $table->dropColumn('administratively_locked');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('profileShortBio')->nullable();
            $table->text('profileAboutMe')->nullable();
            $table->enum('avatarPreference', [
                'crafatar', // Mojang Profile
                'gravatar' // Email profile
            ])->default('gravatar');
            $table->text('socialLinks')->nullable();
            $table->bigInteger('userID')->unsigned();
            $table->timestamps();

            $table->foreign('userID')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}

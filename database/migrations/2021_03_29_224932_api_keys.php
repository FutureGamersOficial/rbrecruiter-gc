<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // API keys can only access resources the owner's account can access
        Schema::create('api_keys', function (Blueprint $table) {

            $table->id();
            $table->string('discriminator');
            $table->string('secret');
            $table->enum('status', ['disabled', 'active']);
            $table->bigInteger('owner_user_id')->unsigned();

            $table->foreign('owner_user_id')
                ->references('id')
                ->on('users')
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
        //
    }
}

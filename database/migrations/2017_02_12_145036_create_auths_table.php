<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auths', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('ip');
            $table->string('user_agent');
            $table->text('raw_request_params');
            $table->text('o_auth_token')->nullable();
            $table->text('o_auth_refresh_token')->nullable();
            $table->string('token_generated')->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->timestamp('expiration')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auths');
    }
}

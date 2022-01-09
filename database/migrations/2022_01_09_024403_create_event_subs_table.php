<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_subs', function (Blueprint $table) {
            $table->id();
            $table->string('event_id');
            $table->string('user_id');
            $table->string('user_name');
            $table->string('broadcaster_user_id');
            $table->string('broadcaster_user_name');
            $table->dateTime('followed_at');
            $table->string('user_id');
            $table->string('type');
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
        Schema::dropIfExists('event_subs');
    }
}

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
            $table->string('broadcaster_user_id');
            $table->string('broadcaster_user_name');
            $table->string('type');

            //from
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();

            //Follower
            $table->string('followed_at')->nullable();

            //sub & gif sub
            $table->string('tier')->nullable();
            $table->boolean('is_gift')->nullable()->default(false);
            $table->integer('total')->nullable();
            $table->integer('cumulative_total')->nullable();
            $table->boolean('is_anonymous')->nullable()->default(false);
            $table->integer('cumulative_months')->nullable();
            $table->integer('streak_months')->nullable();
            $table->integer('duration_months')->nullable();

            //cheers
            $table->string('message')->nullable();
            $table->integer('bits')->nullable();

            //raid
            $table->string('from_broadcaster_user_id')->nullable();
            $table->string('from_broadcaster_user_login')->nullable();
            $table->string('from_broadcaster_user_name')->nullable();
            $table->bigInteger('viewers')->nullable();



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

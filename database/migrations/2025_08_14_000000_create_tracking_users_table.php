<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingUsersTable extends Migration
{
    public function up()
    {
        Schema::create('tracking_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('role');
            $table->integer('grade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('tracking_users');
    }
}

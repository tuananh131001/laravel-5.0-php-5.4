<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAIJuniorDevelopersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_junior_developers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('years_experience');
            $table->boolean('has_ai_knowledge')->default(false);
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
        Schema::drop('ai_junior_developers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareRiskAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_risk_assessments', function (Blueprint $table) {
            $table->string('external_software_key')->primary();
            $table->string('app_key');
            $table->float('risk_score');
            $table->string('risk_level');
            $table->string('software_category_key');
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->string('version_name');
            $table->timestamp('version_timestamp');
            
            $table->foreign('software_category_key')
                  ->references('category_key')
                  ->on('software_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('software_risk_assessments');
    }
}

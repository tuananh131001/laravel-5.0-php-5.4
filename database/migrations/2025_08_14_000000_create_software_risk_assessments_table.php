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
            $table->id();
            $table->string('app_key');
            $table->string('external_software_key');
            $table->float('risk_score');
            $table->string('risk_level');
            $table->string('software_category_key');
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('version_name');
            $table->timestamp('version_timestamp');
            
            $table->unique(['external_software_key', 'version_name']);
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

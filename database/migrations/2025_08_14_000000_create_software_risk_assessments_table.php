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
            $table->string('app_key')->nullable();
            $table->string('external_software_key')->primary();
            $table->float('risk_score')->nullable();
            $table->string('risk_level', 50)->nullable();
            $table->string('software_category_key')->nullable();
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('version_name')->nullable();
            $table->timestamp('version_timestamp')->nullable();
            
            $table->foreign('external_software_key')
                  ->references('external_software_key')
                  ->on('software_lookup')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('software_risk_assessments', function (Blueprint $table) {
            $table->dropForeign(['external_software_key']);
        });
        
        Schema::dropIfExists('software_risk_assessments');
    }
}

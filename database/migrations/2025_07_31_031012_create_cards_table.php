<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cards', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('client_id');
			$table->unsignedInteger('product_id');
			$table->string('activation_number')->unique();
			$table->string('pin')->nullable();
			$table->enum('status', ['active', 'cancelled'])->default('active');
			$table->timestamp('cancelled_at')->nullable();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			$table->softDeletes();
			
			$table->foreign('client_id')
				->references('id')
				->on('clients')
				->onDelete('cascade');
				
			$table->foreign('product_id')
				->references('id')
				->on('products')
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
		Schema::drop('cards');
	}

}
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_product', function(Blueprint $table)
		{
			$table->unsignedInteger('client_id');
			$table->unsignedInteger('product_id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

			$table->primary(['client_id', 'product_id']);
			
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
		Schema::drop('client_product');
	}

}
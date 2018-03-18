<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProdukHukumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('produk_hukums', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('group_egovernment_id');
			$table->string('label')->nullable();
			$table->string('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::drop('produk_hukums');
	}
}

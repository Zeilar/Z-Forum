<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('title');
			$table->string('slug');
			$table->string('icon')->default('default.png');
			$table->unsignedInteger('category_id');
            $table->timestamps();
            $table->softDeletes();
			$table->string('table_name')->default('subcategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategories');
    }
}
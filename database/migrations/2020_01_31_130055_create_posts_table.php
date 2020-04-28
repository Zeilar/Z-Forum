<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->text('content');
			$table->string('edited_by')->nullable();
			$table->string('edited_by_message')->nullable();
			$table->unsignedInteger('thread_id');
			$table->unsignedInteger('user_id')->nullable();
			$table->unsignedInteger('subcategory_id');
			$table->unsignedInteger('category_id');
            $table->timestamps();
			$table->string('table_name')->default('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

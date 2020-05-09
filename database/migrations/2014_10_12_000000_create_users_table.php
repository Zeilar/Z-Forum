<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('username')->nullable()->unique();
			$table->string('github_id')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
			$table->enum('role', ['member', 'moderator', 'superadmin'])->nullable()->default('member');
			$table->enum('rank', ['infant', 'pioneer', 'veteran', 'cave dweller'])->nullable()->default('infant');
			$table->text('signature')->nullable();
			$table->string('avatar')->nullable()->default(route('index') . '/storage/user-avatars/default.svg');
			$table->json('settings')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamp('email_verified_at')->nullable();
			$table->timestamp('last_seen')->nullable()->default(\Carbon\Carbon::now());
			$table->timestamp('suspended')->nullable();
            $table->timestamps();
			$table->string('table_name')->default('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

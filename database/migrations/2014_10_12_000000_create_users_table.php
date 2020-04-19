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
			$table->string('username')->unique();
			$table->string('github_id')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable(); // Nullable in case user logs in with OAuth
			$table->enum('role', ['member', 'moderator', 'superadmin'])->default('member');
			$table->enum('rank', ['infant', 'pioneer', 'veteran', 'cave dweller'])->default('infant');
			$table->text('signature')->nullable();
			$table->string('avatar')->default(route('index') . '/storage/user-avatars/default.svg');
			$table->json('settings')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
			$table->timestamp('last_seen')->default(\Carbon\Carbon::now());
			$table->timestamp('banned')->nullable();
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

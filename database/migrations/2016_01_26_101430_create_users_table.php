<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password', 60);
            // Role
            $table->integer('user_role_id')->unsigned();
            $table->foreign('user_role_id')->references('id')->on('users_roles');
            // Subrole (only for doctors). Nullable() because only doctor roles have subroles.
            $table->integer('user_subrole_id')->unsigned()->nullable();
            $table->foreign('user_subrole_id')->references('id')->on('users_subroles');
            // Activation status (0 or 1)
            $table->boolean('activation_status')->default(0);
            $table->boolean('is_deactivated')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

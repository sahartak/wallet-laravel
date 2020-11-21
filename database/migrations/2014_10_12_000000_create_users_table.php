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
            $table->integer('id')->autoIncrement()->unsigned();
            $table->string('name');
            $table->string('email', 191)->unique();
            $table->float('balance')->default(0);
            $table->string('phone', 191)->unique();
            $table->timestamp('birthdate')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('role')->default(\App\Models\User::ROLE_USER)->comment('0 - user, 1 - admin');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->longText('bio')->nullable();
            $table->string('profilepic')->default('default.jpg');
            $table->enum('gender',['male','female'])->default('male');
            $table->enum('active',['yes','no','blocked'])->default('no');
            $table->enum('status',['single','married','commited'])->default(null);
            $table->date('dob')->nullable();
            $table->string('mobile',13)->nullable();
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
};

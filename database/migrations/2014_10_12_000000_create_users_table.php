<?php

use Illuminate\Support\Facades\Schema;
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
      $table->string('avatar', 100)->nullable();
      $table->string('first_name', 100)->nullable();
      $table->string('last_name', 100)->nullable();
      $table->string('email')->unique();
      $table->integer('employee_number')->nullable();
      $table->string('password');
      $table->unsignedInteger('role_id')->nullable();
      $table->double('rate')->nullable();
      $table->string('phone_number', 100)->nullable();
      $table->text('medical_notes')->nullable();
      $table->string('emergency_contact_name', 100)->nullable();
      $table->string('emergency_contact_phone', 100)->nullable();
      $table->rememberToken();
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
    Schema::dropIfExists('users');
  }
}

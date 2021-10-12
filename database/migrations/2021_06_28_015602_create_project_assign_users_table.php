<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAssignUsersTable extends Migration
{
  public function up()
  {
    Schema::create('project_assign_users', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('assign_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->string('title', 100)->nullable();
      $table->string('note', 100)->nullable();
      $table->timestamps();

      $table->foreign('assign_id', 'project_assign_users_assign_id')->references('id')->on('project_assigns')->onDelete('cascade');
      $table->foreign('user_id', 'project_assign_users_user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('project_assign_users');
  }
}

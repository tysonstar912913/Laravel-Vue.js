<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimecardsTable extends Migration
{
  public function up()
  {
    Schema::create('timecards', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('user_id')->nullable();
      $table->unsignedInteger('assign_id')->nullable();
      $table->unsignedInteger('project_id')->nullable();
      $table->dateTime('check_in')->nullable();
      $table->dateTime('check_out')->nullable();
      $table->integer('entry')->nullable()->comment('seconds');
      $table->timestamps();

      $table->foreign('user_id', 'timecards_user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('assign_id', 'timecards_assign_id')->references('id')->on('project_assigns')->onDelete('cascade');
      $table->foreign('project_id', 'timecards_project_id')->references('id')->on('projects')->onDelete('cascade');
    });
  }
  
  public function down()
  {
    Schema::dropIfExists('timecards');
  }
}

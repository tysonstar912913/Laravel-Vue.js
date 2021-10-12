<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAssignProjectsTable extends Migration
{
  public function up()
  {
    Schema::create('project_assign_projects', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('assign_id')->nullable();
      $table->unsignedInteger('project_id')->nullable();
      $table->string('note', 100)->nullable();
      $table->timestamps();

      $table->foreign('assign_id', 'project_assign_projects_assign_id')->references('id')->on('project_assigns')->onDelete('cascade');
      $table->foreign('project_id', 'project_assign_projects_project_id')->references('id')->on('projects')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('project_assign_projects');
  }
}

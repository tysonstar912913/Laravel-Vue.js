<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAssignsTable extends Migration
{
  public function up()
  {
    Schema::create('project_assigns', function (Blueprint $table) {
      $table->increments('id');
      $table->string('note', 100)->nullable();
      $table->timestamps();
    });
  }
  
  public function down()
  {
    Schema::dropIfExists('project_assigns');
  }
}

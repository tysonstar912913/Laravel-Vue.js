<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTitlesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_titles', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('user_id')->nullable();
      $table->unsignedInteger('title_id')->nullable();
      $table->tinyInteger('is_include')->nullable();
      $table->timestamps();

      $table->softDeletes();

      $table->foreign('user_id', 'user_titles_user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('title_id', 'user_titles_title_id')->references('id')->on('titles')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_titles');
  }
}

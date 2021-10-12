<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('projects', function (Blueprint $table) {
      $table->increments('id');
      $table->string('project', 200)->nullable();
      $table->integer('project_number')->nullable();
      $table->enum('status', ['Active', 'On Deck'])->nullable();
      $table->date('start_date')->nullable();
      $table->date('end_date')->nullable();
      $table->string('country', 100)->nullable();
      $table->string('address', 200)->nullable();
      $table->string('city', 100)->nullable();
      $table->string('region', 100)->nullable();
      $table->string('postal_code', 10)->nullable();
      $table->double('latitude')->nullable();
      $table->double('longitude')->nullable();
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
    Schema::dropIfExists('projects');
  }
}

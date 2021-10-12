<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_permissions', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('user_id')->nullable();
      $table->unsignedInteger('permission_id')->nullable();
      $table->tinyInteger('permission')->nullable();
      $table->timestamps();

      $table->softDeletes();

      $table->foreign('user_id', 'user_permissions_user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('permission_id', 'user_permissions_permission_id')->references('id')->on('permission_lists')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_permissions');
  }
}

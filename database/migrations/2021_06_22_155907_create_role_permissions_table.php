<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('role_permissions', function (Blueprint $table) {
      $table->increments('id');

      $table->unsignedInteger('role_id')->nullable();
      $table->unsignedInteger('permission_id')->nullable();
      $table->tinyInteger('permission')->nullable();
      $table->timestamps();

      $table->softDeletes();
      
      $table->foreign('role_id', 'role_permissions_role_id')->references('id')->on('roles')->onDelete('cascade');
      $table->foreign('permission_id', 'role_permissions_permission_id')->references('id')->on('permission_lists')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('role_permissions');
  }
}

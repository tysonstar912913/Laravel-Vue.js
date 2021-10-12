<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateProjectsTableProjectNumberField extends Migration
{
  public function up()
  {
    $sql = "ALTER TABLE `projects` CHANGE `project_number` `project_number` VARCHAR(100) NULL";
    DB::statement($sql);
  }


  public function down()
  {
    $sql = "ALTER TABLE `projects` CHANGE `project_number` `project_number` INT(11) NULL";
    DB::statement($sql);
  }
}

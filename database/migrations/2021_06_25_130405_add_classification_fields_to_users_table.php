<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddClassificationFieldsToUsersTable extends Migration
{
  public function up()
  {
    $sql = "ALTER TABLE `users`
      ADD COLUMN `trade` VARCHAR(100) NULL AFTER `deleted_at`,
      ADD COLUMN `pay_class` VARCHAR(100) NULL AFTER `trade`,
      ADD COLUMN `tags` VARCHAR(100) NULL AFTER `pay_class`,
      ADD COLUMN `classification` VARCHAR(100) NULL AFTER `tags`,
      ADD COLUMN `is_collaborator` TINYINT NULL AFTER `classification`,
      ADD COLUMN `send_invitation_email` TINYINT NULL AFTER `is_collaborator`
    ";

    DB::statement($sql);
  }
  
  public function down()
  {
    $sql = "ALTER TABLE `users`
      DROP COLUMN `trade`,
      DROP COLUMN `pay_class`,
      DROP COLUMN `tags`,
      DROP COLUMN `classification`,
      DROP COLUMN `is_collaborator`,
      DROP COLUMN `send_invitation_email`
    ";

    DB::statement($sql);
  }
}

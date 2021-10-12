<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = [
    'project',
    'project_number',
    'status',
    'start_date',
    'end_date',
    'country',
    'address',
    'city',
    'region',
    'postal_code',
    'latitude',
    'longitude'
  ];

  protected $dates = ['deleted_at'];

  public function getAssignedUserList() {
    $sql = "SELECT
      `users`.`id` `user_id`,
      `users`.`first_name`,
      `users`.`avatar`
    FROM
      `project_assign_projects`
      LEFT JOIN `project_assign_users`
        ON `project_assign_users`.`assign_id` = `project_assign_projects`.`assign_id`
      LEFT JOIN `users`
        ON `users`.`id` = `project_assign_users`.`user_id`
    WHERE
      `project_assign_projects`.`project_id` = '" . $this->id . "'
    ";
    $data = DB::select($sql);
    return $data;
  }
}

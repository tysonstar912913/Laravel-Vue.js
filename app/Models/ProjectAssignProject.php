<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAssignProject extends Model
{
  protected $fillable = [
    'assign_id',
    'project_id',
    'note'
  ];
}

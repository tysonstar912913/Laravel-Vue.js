<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAssignUser extends Model
{
  protected $fillable = [
    'assign_id',
    'user_id',
    'title',
    'note'
  ];
}

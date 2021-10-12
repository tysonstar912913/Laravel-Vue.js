<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionList extends Model
{
  protected $fillable = [
    'title'
  ];

  protected $dates = ['deleted_at'];
}

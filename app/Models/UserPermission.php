<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
  protected $fillable = [
    'user_id',
    'permission_id',
    'permission'
  ];

  protected $dates = ['deleted_at'];
}

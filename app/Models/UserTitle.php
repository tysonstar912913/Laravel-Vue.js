<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTitle extends Model
{
  protected $fillable = [
    'user_id',
    'title_id',
    'is_include'
  ];

  protected $dates = ['deleted_at'];
}

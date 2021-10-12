<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
  protected $fillable = [
    'title'
  ];
  
  protected $dates = ['deleted_at'];
}

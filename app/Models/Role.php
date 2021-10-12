<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $fillable = [
    'title'
  ];
  
  protected $dates = ['deleted_at'];
  
  public function permissions()
  {
    return $this->hasMany(RolePermission::class, 'role_id', 'id');
  }
}

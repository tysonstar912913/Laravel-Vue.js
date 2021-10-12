<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;


/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $remember_token
 */
class User extends Authenticatable
{
  use Notifiable;
  use HasApiTokens;

  protected $fillable = [
    'avatar',
    'first_name',
    'last_name',
    'email',
    'password',
    'employee_number',
    'remember_token',
    'role_id',
    'rate',
    'phone_number',
    'medical_notes',
    'emergency_contact_name',
    'emergency_contact_phone',
    'trade',
    'pay_class',
    'tags',
    'classification',
    'is_collaborator',
    'send_invitation_email',
    'company_id'
  ];

  protected $hidden = ['password', 'remember_token'];
  protected $dates = ['deleted_at'];

  /**
   * Hash password
   * @param $input
   */
  public function setPasswordAttribute($input)
  {
    if ($input)
      $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
  }

  /**
   * Set to null if empty
   * @param $input
   */
  public function setRoleIdAttribute($input)
  {
    $this->attributes['role_id'] = $input ? $input : null;
  }

  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id');
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  public function permissions()
  {
    return $this->hasMany(UserPermission::class, 'user_id', 'id');
  }

  public function titles()
  {
    return $this->hasMany(UserTitle::class, 'user_id', 'id');
  }

  public function setCompanyIdAttribute($input)
  {
    $this->attributes['company_id'] = $input ? $input : null;
  }
  
  public function company()
  {
    return $this->belongsTo(Company::class, 'company_id')->withTrashed();
  }

  public function setDefaultPermissions() {
    $sql = "DELETE FROM `user_permissions` WHERE `user_id`='" . $this->id . "'";
    DB::statement($sql);
    $sql = "INSERT INTO `user_permissions` (`user_id`, `permission_id`, `permission`)
      (SELECT '" . $this->id . "', `permission_id`, '1' FROM `role_permissions` WHERE `role_id`='". $this->role_id . "')
    ";
    DB::statement($sql);
  }
}

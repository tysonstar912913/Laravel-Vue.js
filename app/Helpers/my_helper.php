<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

if (!function_exists('getAuthPermission')) {
  function getAuthPermission() {
    $auth = User::with([
      'role:id,title',
      'permissions:id,user_id,permission_id,permission',
      'titles:id,user_id,title_id,is_include',
      'company'
    ])->findOrFail(Auth::id());

    return $auth->role->title;
  }
}
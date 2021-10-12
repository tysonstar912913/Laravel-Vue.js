<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserTitle;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
  private function _updateTitles($userid, $titles)
  {
    UserTitle::where('user_id', $userid)->delete();
    foreach ($titles as $title) {
      UserTitle::create([
        'user_id' => $userid,
        'title_id' => $title['title_id'],
        'is_include' => 1
      ]);
    }
  }

  private function _updatePermissions($userid, $permissions)
  {
    UserPermission::where('user_id', $userid)->delete();
    foreach ($permissions as $permission) {
      UserPermission::create([
        'user_id' => $userid,
        'permission_id' => $permission['permission_id'],
        'permission' => 1
      ]);
    }
  }

  private function _getUserInfo($userid)
  {
    $user = User::with([
      'role:id,title',
      'permissions:id,user_id,permission_id,permission',
      'titles:id,user_id,title_id,is_include',
      'company'
    ])->findOrFail($userid);
    return $user;
  }

  public function index()
  {
    return new UserResource(User::with([
      'role:id,title',
      'permissions:id,user_id,permission_id,permission',
      'titles:id,user_id,title_id,is_include'
    ])->get());
  }

  public function show($id)
  {
    $user = $this->_getUserInfo($id);

    return new UserResource($user);
  }

  public function store(StoreUsersRequest $request)
  {
    $user = User::create([
      'avatar' => $request->avatar,
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'password' => bcrypt('1'),
      'employee_number' => $request->employee_number,
      'role_id' => $request->role_id,
      'rate' => $request->rate,
      'phone_number' => $request->phone_number,
      'medical_notes' => $request->medical_notes,
      'emergency_contact_name' => $request->emergency_contact_name,
      'emergency_contact_phone' => $request->emergency_contact_phone,
      'trade' => $request->trade,
      'pay_class' => $request->pay_class,
      'tags' => $request->tags,
      'classification' => $request->classification,
      'is_collaborator' => $request->is_collaborator,
      'send_invitation_email' => $request->send_invitation_email,
      'company_id' => $request->company_id
    ]);

    // update titles and permissions
    $this->_updateTitles($user->id, $request->titles);
    $user->setDefaultPermissions();

    $user = $this->_getUserInfo($user->id);

    return (new UserResource($user))
      ->response()
      ->setStatusCode(201);
  }

  public function update(UpdateUsersRequest $request, $id)
  {
    $user = User::findOrFail($id);
    $oldRoleId = $user->role_id;
    $user->update([
      'avatar' => $request->avatar,
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'employee_number' => $request->employee_number,
      'role_id' => $request->role_id,
      'rate' => $request->rate,
      'phone_number' => $request->phone_number,
      'medical_notes' => $request->medical_notes,
      'emergency_contact_name' => $request->emergency_contact_name,
      'emergency_contact_phone' => $request->emergency_contact_phone,
      'trade' => $request->trade,
      'pay_class' => $request->pay_class,
      'tags' => $request->tags,
      'classification' => $request->classification,
      'is_collaborator' => $request->is_collaborator,
      'send_invitation_email' => $request->send_invitation_email,
      'company_id' => $request->company_id
    ]);

    if ($oldRoleId !== $user->role_id) {
      $user->setDefaultPermissions();
    } else {
      // update titles and permissions
      $this->_updateTitles($user->id, $request->titles);
      $this->_updatePermissions($user->id, $request->permissions);
    }

    $user = $this->_getUserInfo($user->id);

    return (new UserResource($user))
      ->response()
      ->setStatusCode(202);
  }

  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return response(null, 204);
  }

  public function getAuth()
  {
    return response($this->_getUserInfo(Auth::id()));
  }
}

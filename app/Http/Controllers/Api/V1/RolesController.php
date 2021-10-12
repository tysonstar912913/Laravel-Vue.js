<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Role;
use App\Models\RolePermission;
use App\Http\Controllers\Controller;
use App\Http\Resources\Role as RoleResource;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use Illuminate\Http\Request;



class RolesController extends Controller
{
    private function _updatePermissions($roleid, $permissions)
    {
        RolePermission::where('role_id', $roleid)->delete();
        foreach ($permissions as $permission) {
            RolePermission::create([
                'role_id' => $roleid,
                'permission_id' => $permission['permission_id'],
                'permission' => 1
            ]);
        }
    }

    public function index()
    {
        return new RoleResource(Role::with(['permissions:id,role_id,permission_id,permission'])->get());
    }

    public function show($id)
    {
        $role = Role::with(['permissions:id,role_id,permission_id,permission'])->findOrFail($id);

        return new RoleResource($role);
    }

    public function store(StoreRolesRequest $request)
    {
        $role = Role::create($request->all());
        $this->_updatePermissions($role->id, $request->permissions);
        $role = Role::with(['permissions:id,role_id,permission_id,permission'])->findOrFail($role->id);

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateRolesRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        $this->_updatePermissions($role->id, $request->permissions);
        $role = Role::with(['permissions:id,role_id,permission_id,permission'])->findOrFail($role->id);

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response(null, 204);
    }
}

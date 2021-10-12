<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\PermissionList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionListController extends Controller
{
  public function json($data) {
    return response()->json(['data' => $data]);
  }

  public function index()
  {
    return $this->json(PermissionList::all());
  }

  public function show($id)
  {
    return $this->json(PermissionList::find($id));
  }

  public function store(Request $request)
  {
    $permissionList = PermissionList::create($request->all());
    return $this->json($permissionList);
  }

  public function update(Request $request, $id)
  {
    $permissionList = PermissionList::findOrFail($id);
    $permissionList->update($request->all());
    return $this->json($permissionList);
  }

  public function destroy($id)
  {
    $permissionList = PermissionList::find($id);
    if ($permissionList) {
      $permissionList->delete();
    }

    return response(null, 204);
  }
}

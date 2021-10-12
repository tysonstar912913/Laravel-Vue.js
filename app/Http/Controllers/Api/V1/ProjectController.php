<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
  public function index()
  {
    $data = Project::all();
    return response()->json($data);
  }

  public function store(Request $request)
  {
    // ---------- Begin validation -----------------------------
    if (!$request->filled('project')) {
      return response()->json([
        'status' => false,
        'msg' => 'Please input Project name'
      ]);
    }

    if (!$request->filled('project_number')) {
      return response()->json([
        'status' => false,
        'msg' => 'Please input Project number'
      ]);
    }

    if (!$request->filled('start_date')) {
      return response()->json([
        'status' => false,
        'msg' => 'Please input Start date'
      ]);
    }
    // ---------- End validation --------------------------------

    $project = Project::create([
      'project' => $request->project,
      'project_number' => $request->project_number,
      'status' => $request->status,
      'start_date' => $request->start_date,
      'end_date' => $request->end_date,
      'country' => $request->country,
      'address' => $request->address,
      'city' => $request->city,
      'region' => $request->region,
      'postal_code' => $request->postal_code,
      'longitude' => $request->longitude,
      'latitude' => $request->latitude
    ]);

    return response()->json([
      'status' => true,
      'project' => $project
    ]);
  }

  public function show($id)
  {
    $project = Project::find($id);
    return response()->json($project);
  }

  public function update(Request $request, $id)
  {
    $project = Project::find($id);
    if ($project == null) {
      return response()->json([
        'status' => false,
        'msg' => 'Cannot find specific project'
      ]);
    }

    // ---------- Begin validation -----------------------------
    if (!$request->filled('project')) {
      return response()->json([
        'status' => false,
        'msg' => 'Please input Project name'
      ]);
    }

    if (!$request->filled('project_number')) {
      return response()->json([
        'status' => false,
        'msg' => 'Please input Project number'
      ]);
    }

    if (!$request->filled('start_date')) {
      return response()->json([
        'status' => false,
        'msg' => 'Please input Start date'
      ]);
    }
    // ---------- End validation --------------------------------

    $project->update([
      'project' => $request->project,
      'project_number' => $request->project_number,
      'status' => $request->status,
      'start_date' => $request->start_date,
      'end_date' => $request->end_date,
      'country' => $request->country,
      'address' => $request->address,
      'city' => $request->city,
      'region' => $request->region,
      'postal_code' => $request->postal_code,
      'longitude' => $request->longitude,
      'latitude' => $request->latitude
    ]);

    return response()->json([
      'status' => true,
      'project' => $project
    ]);
  }

  public function destroy($id)
  {
    $project = Project::find($id);
    if ($project == null) {
      return response()->json([
        'status' => false,
        'msg' => 'Cannot find specific project'
      ]);
    }

    $project->delete();
    return response()->json([
      'status' => true,
      'msg' => 'Deleted project'
    ]);
  }

  public function getAssignAll()
  {
    $sql = "SELECT
      `projects`.`id`,
      `projects`.`project`,
      `projects`.`city`,
      `projects`.`region`,
      `projects`.`address`,
      `projects`.`country`,
      `projects`.`start_date`,
      `projects`.`end_date`,
      `users`.`id` `user_id`,
      `users`.`first_name`,
      `users`.`avatar`
    FROM
      `projects`
      LEFT JOIN `project_assign_projects`
        ON `project_assign_projects`.`project_id` = `projects`.`id`
      LEFT JOIN `project_assign_users`
        ON `project_assign_users`.`assign_id` = `project_assign_projects`.`assign_id`
      LEFT JOIN `users`
        ON `users`.`id` = `project_assign_users`.`user_id`
    ";
    $data = DB::select($sql);

    $retData = [];
    foreach ($data as $row) {
      for ($i = count($retData) - 1; $i >= 0; $i -= 1) {
        if ($retData[$i]['id'] == $row->id) {
          break;
        }
      }

      if ($i > -1) {
        if (!is_array($retData[$i]['users'])) {
          $retData[$i]['users'] = [];
        }
        array_push($retData[$i]['users'], [
          'id' => $row->id,
          'first_name' => $row->first_name,
          'avatar' => $row->avatar
        ]);
      } else {
        $row1 = [
          'id' => $row->id,
          'project' => $row->project,
          'city' => $row->city,
          'region' => $row->region,
          'address' => $row->address,
          'country' => $row->country,
          'start_date' => $row->start_date,
          'end_date' => $row->end_date,
          'users' => []
        ];

        if ($row->user_id != null) {
          array_push($row1['users'], [
            'id' => $row->user_id,
            'first_name' => $row->first_name,
            'avatar' => $row->avatar
          ]);
        }
        array_push($retData, $row1);
      }
    }
    return response()->json($retData);
  }

  public function getAssignedUserList($projectId)
  {
    $project = Project::find($projectId);
    $data = $project->getAssignedUserList($projectId);
    return response()->json($data);
  }
}

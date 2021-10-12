<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProjectAssign;
use App\Models\ProjectAssignProject;
use App\Models\ProjectAssignUser;

class ProjectAssignController extends Controller
{
  public function index()
  {
    //
  }

  public function store(Request $request)
  {
    $users = $request->users;
    $projects = $request->projects;
    $note = $request->filled('note') ? $request->note : null;

    $assign = ProjectAssign::create([
      'note' => $note
    ]);

    foreach ($users as $user) {
      ProjectAssignUser::create([
        'assign_id' => $assign->id,
        'user_id' => $user['id'],
        'title' => $user['title'],
        'note' => isset($user['note']) ? $user['note'] : null
      ]);
    }

    foreach ($projects as $project) {
      ProjectAssignProject::create([
        'assign_id' => $assign->id,
        'project_id' => $project['id'],
        'note' => isset($project['note']) ? $project['note'] : null
      ]);
    }
  }

  public function show($id)
  {
    //
  }

  public function update(Request $request, $id)
  {
    //
  }

  public function destroy($id)
  {
    //
  }
}

<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Timecard;
use App\Models\User;
use App\Models\Project;

class TimecardController extends Controller
{
  public function index()
  {
  }

  public function store(Request $request)
  {
    $role = getAuthPermission();
    $createdData = $request->createdData;
    $updatedData = $request->updatedData;
    $deletedData = $request->deletedData;
    foreach ($createdData as $row) {
      Timecard::create([
        'user_id' => $role === 'Admin' ? $request['user_id'] : Auth::id(),
        'assign_id' => $row['assign_id'],
        'project_id' => $row['project_id'],
        'check_in' => $row['check_in'],
        'check_out' => $row['check_out'],
        'entry' => $row['entry']
      ]);
    }
    foreach ($updatedData as $row) {
      $timeCard = Timecard::find($row['id']);
      $timeCard->update([
        'user_id' => $role === 'Admin' ? $request['user_id'] : Auth::id(),
        'assign_id' => $row['assign_id'],
        'project_id' => $row['project_id'],
        'check_in' => $row['check_in'],
        'check_out' => $row['check_out'],
        'entry' => $row['entry']
      ]);
    }
    foreach ($deletedData as $row) {
      Timecard::destroy($row);
    }

    return 'success';
  }

  public function show($id)
  {
  }

  public function update(Request $request, $id)
  {
  }

  public function destroy($id)
  {
  }

  public function getUserList($projectId)
  {
  }

  public function getAll($projectId, $startDate, $endDate)
  {
    $tempData = [];
    $project = Project::find($projectId);
    // get all user data
    $userData = $project->getAssignedUserList();
    foreach ($userData as $row) {
      $tempData[$row->user_id]['userData'] = $row;
    }

    // get timecard data for specific date
    $data = Timecard::where('project_id', $projectId)
      ->whereRaw('DATE(entry_date) >= ? ', [$startDate])
      ->whereRaw('DATE(entry_date) <= ? ', [$endDate])
      ->get(['id', 'user_id', 'check_in', 'check_out', 'duration', 'entry_date', 'created_at']);

    $staticData = [];
    foreach ($data as $row) {
      if(!isset($tempData[$row->user_id]['staticData'])) $tempData[$row->user_id]['staticData'] = [];
      array_push($tempData[$row->user_id]['staticData'], $row);
    }
    // set return data
    $retData = [];
    foreach ($tempData as $key => $row) {
      array_push($retData, [
        'userId' => $key,
        'projectId' => $projectId,
        'userData' => $row['userData'],
        'staticData' => isset($row['staticData']) ? $row['staticData'] : null,
      ]);
    }

    return response()->json($retData);
  }

  public function addEntry()
  {
    $data = request()->all();
    $entry = [
      'user_id' => $data['userId'],
      'project_id' => $data['projectId'],
      'cost_code' => $data['entryCostCode'],
      'time_type' => $data['entryTimeType'],
      'duration' => $data['entryDuration'],
      'equipment' => $data['entryTool'],
      'classification' => $data['entryClassification'],
      'description' => $data['entryNotes'],
      'entry_date' => $data['entryDate'],
    ];

    // $entryCount = Timecard::where($entry)->get()->count();
    $isUpdate = $data['isUpdate'];
    $isCompleteCheckin = $data['isCompleteCheckin'];

    if(!$isUpdate) {
      if($isCompleteCheckin) {
        $entry['check_in'] = $data['checkin'];
        $entry['check_out'] = $data['checkout'];
        $entry['duration'] = $data['checkout'] - $data['checkin'];
      }
      
      $result = Timecard::create($entry);
    }
    else {
      $id = $data['id'];
      $result = Timecard::find($id)->update($entry);
    }
    return response()->json($result);
  }
  
  public function deleteEntry($id)
  {
    $entry = Timecard::where('id', $id)->first();
    Timecard::find($id)->delete();
    return response()->json($entry);
  }

  public function addCheckin()
  {
    $data = request()->all();
    $title = $data['title'];
    $id = $data['id'];
    $entry = [
      'user_id' => $data['userId'],
      'project_id' => $data['projectId'],
      'entry_date' => $data['entryDate'],
    ];
    if($id == 0) {
      $entry['check_in'] = $data['checkIn'];
      $result = Timecard::create($entry);
    }
    else {
      $entry[$title] = $data['checkIn'];
      
      $entry['time_type'] = 'Regular Time - RT';
      $entry['duration'] = 'check_out-check_in';
      $result = DB::update('UPDATE timecards SET '.$title.'=?, duration=(check_out-check_in), time_type=? WHERE id=?', [
        $data['checkIn'], 'Regular Time - RT', $data['id']
      ]);
    }
    
    return response()->json($result);
  }

  public function getUserData($projectId, $userId, $startDate, $endDate)
  {
    $userData = User::find($userId);
    $data = Timecard::where('project_id', $projectId)
      ->where('user_id', $userId)
      ->where('start_date', '>=', $startDate)
      ->where('end_date', '<=', $endDate)
      ->get();

    return response()->json([
      'userId' => $userId,
      'userData' => $userData,
      'cardData' => $data
    ]);
  }
  
  public function getWeekData($projectId, $userId, $startDate, $endDate)
  {
    $data = Timecard::where('project_id', $projectId)
      ->where('user_id', $userId)
      ->whereRaw('DATE(entry_date) >= ? ', [$startDate])
      ->whereRaw('DATE(entry_date) <= ? ', [$endDate])
      ->get();
    
    // foreach ($data as $row) {
    //   if(!isset($data[$row->user_id]['checkins'])) $checkins[$row->user_id]['checkins'] = [];
    //   if(!isset($data[$row->user_id]['entries'])) $entries[$row->user_id]['entries'] = [];
      
    //   array_push($checkins[$row->user_id], [$row['id'], $row['user_id'], $row['project_id'], $row['check_in'], $row['check_out'], $row['entry_date']]);
    //   array_push($entries[$row->user_id], [$row['id'], $row['user_id'], $row['project_id'], $row['cost_code'], $row['time_type'], $row['equipment'], $row['classification'], $row['description'], $row['duration'], $row['entry_date']]);
    // }

    return response()->json([
      'weekData' => $data,
      'startDate' => $startDate,
      'endDate' => $endDate,      
      // 'checkins' => $checkins,  
      // 'entries' => $entries,
    ]);
  }

  public function getCheckinsData()
  {
    $data = request()->all();
    $params = [
      'user_id' => $data['userId'],
      'project_id' => $data['projectId'],
      'entry_date' => $data['entryDate'],
    ];

    $data = Timecard::where($params)
      ->get();

    return response()->json($data);
  }

  public function deleteCheckin($id)
  {
    $entry = Timecard::where('id', $id)->first();
    Timecard::find($id)->delete();
    return response()->json($entry);
  }
}

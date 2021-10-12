<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Title;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TitleController extends Controller
{
  public function json($data) {
    return response()->json(['data' => $data]);
  }

  public function index()
  {
    return $this->json(Title::all());
  }

  public function show($id)
  {
    return $this->json(Title::find($id));
  }

  public function store(Request $request)
  {
    $Title = Title::create($request->all());
    return $this->json($Title);
  }

  public function update(Request $request, $id)
  {
    $Title = Title::findOrFail($id);
    $Title->update($request->all());
    return $this->json($Title);
  }

  public function destroy($id)
  {
    $Title = Title::find($id);
    if ($Title) {
      $Title->delete();
    }

    return response(null, 204);
  }
}

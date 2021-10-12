<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
  public function upload(Request $request)
  {
    $path = "";

    if ($request->hasFile('file')) {
      $path = $request->file('file')->store('upload', 'public');
    }
    
    return response()->json([
      'uploadPath' => $path
    ]);
  }
}

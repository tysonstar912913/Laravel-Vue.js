<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timecard extends Model
{
  protected $fillable = [
    'user_id',
    'assign_id',
    'project_id',
    'check_in',
    'check_out',
    'cost_code',
    'time_type',
    'equipment',
    'classification',
    'description',
    'duration',
    'entry_date',
  ];
}

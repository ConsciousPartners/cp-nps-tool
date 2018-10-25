<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Respondent extends Model
{
  protected $fillable = ['email'];
}

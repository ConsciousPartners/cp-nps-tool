<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  protected $fillable = ['id', 'codes_id', 'score', 'feedback'];
  public $timestamps = false;

  public static function generateUniqueId() {
    $id = md5(rand());
    while(Review::where(['id' => $id])->first()) {
      
    }
    return $id;
  }
}

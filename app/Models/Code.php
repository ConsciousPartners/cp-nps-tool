<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
  protected $fillable = ['respondents_id', 'code'];

  public static function generateUniqueCode() {
    $randomCode = md5(rand());
    while(Code::where(['code' => $randomCode])->first()) {
      
    }
    return $randomCode;
  }
}

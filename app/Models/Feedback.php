<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
  protected $fillable = ['id', 'codes_id', 'feedback'];
  protected $table = 'feedbacks';
  public $timestamps = false;
  public $incrementing = false;

  public static function generateUniqueId() {
    $id = md5(rand());
    while(Feedback::where(['id' => $id])->first()) {
      
    }
    return $id;
  }

  public function Code()
  {
    return $this->belongsTo(Code::class, 'codes_id', 'id');
  }  
}

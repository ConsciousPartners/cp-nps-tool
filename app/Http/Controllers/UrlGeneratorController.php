<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Respondent;
use App\Models\Code;
use URL;

class UrlGeneratorController extends Controller
{
  public function index() {
    return view('generate.index');
  }

  public function postGenerate(Request $request) {

    $inputs = $request->all();
    $response = [];

    if ($inputs['email_address']) {

      try {
        $random_code = Code::generateUniqueCode();
        $respondent = Respondent::firstOrNew(['email' => $inputs['email_address']]);
        if (!$respondent->exists) {
          $respondent->save();
        }
  
        $current_code = Code::where(['respondents_id' => $respondent->id, 'active' => TRUE])->first();
        if (is_null($current_code)) {
          $code = Code::firstOrCreate(['code' => $random_code, 'respondents_id' => $respondent->id]);
        } else {
          $response['message'] = 'User currently has an active code.';
          $code = $current_code;
        }

        $response['url'] = URL::to('/?one-time-code=' . $code->code);
        return response()->json($response, 200);
      } catch(\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 400);
      }
    }

  }
}

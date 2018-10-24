<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respondent;
use App\Models\Code;
use App\Models\Review;
use App\Models\Feedback;
use Validator;

class SurveyController extends Controller
{
  public function index(Request $request) {
    $inputs = $request->all();
    if (!isset($inputs['ref'])) {
      abort(404);
    }

    $code = Code::where(['code' => $inputs['ref']])->first();
    if (is_null($code)) {
      abort(404);
    }

    if (!$code->active) {
      abort(400, 'This survey has already expired.');
    }

    return view('survey.index', compact('inputs'));
  }

  public function submit(Request $request) {
    $validator = Validator::make($request->all(), [
      'score' => 'required|numeric',
      'anonymize_score' => 'required|boolean',
      'anonymize_feedback' => 'required|boolean',
    ],[
      'score.required' => 'Please select between 1-10'
    ]);    


    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    try {
      $reviewId = Review::generateUniqueId();
      $feedbackId = Feedback::generateUniqueId();
      $code = Code::where(['code' => $request->input('code')])->first();

      if (!$code->active) {
        abort(400, 'This survey has already expired.');
      }
      $respondent = Respondent::find($code->respondents_id);
      if ($respondent) {
        $respondent->last_send_at = date('Y-m-d');
        $respondent->save();
      }
      $review = Review::firstOrNew(['id' => $reviewId]);

      if ($request->input('anonymize_score') === '0') {
        $review->codes_id = $code->id;
      }

      $review->score = $request->input('score');
      if ($request->input('feedback')) {
        $feedback = Feedback::firstOrNew(['id' => $feedbackId]);
        if ($request->input('anonymize_feedback') === '0') {
          $feedback->codes_id = $code->id;
        }

        $feedback->feedback = $request->input('feedback');
        $feedback->reviewed_at = date('Y-m-d H:i:s');
        $feedback->save();
      }
  
      // Save review
      $review->reviewed_at = date('Y-m-d H:i:s');
      $review->save();
  
      // Set code to inactive
      $code->active = false;
      $code->save();
      
      return redirect()->route('survey::survey.success');
    } catch(\Exception $e) {
      return redirect()
        ->back()
        ->withErrors([$e->getMessage()])
        ->withInput();      
    }
  }

  public function success() {
    return view('survey.success');
  }
}

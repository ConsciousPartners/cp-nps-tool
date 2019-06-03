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
      return view('survey.no-code');
    }

    $code = Code::where(['code' => $inputs['ref']])->first();
    if (is_null($code)) {
      return view('survey.no-code');
    }

    if (!$code->active) {
      return view('survey.expired');
    }

    return view('survey.index', compact('inputs'));
  }

  public function submit(Request $request) {
    $validator = Validator::make($request->all(), [
      'score' => 'required|numeric',
      'anonymize_score' => 'required|boolean',
      'anonymize_feedback' => 'required|boolean',
    ],[
      'score.required' => 'Please choose a response to the first question between 1 and 10.'
    ]);    


    if ($validator->fails()) {
      return response()
            ->json(['success' => 0, 'message' => $validator]);
    }

    try {
      $reviewId = Review::generateUniqueId();
      $feedbackId = Feedback::generateUniqueId();
      $code = Code::where(['code' => $request->input('code')])->first();

      if (!$code->active) {
        return response()
            ->json(['success' => 0, 'message' => [
              'customMessages' => array(
                'error.message' => 'This survey has already expired.'
              )
            ]]);
      }
      $respondent = Respondent::find($code->respondents_id);
      if ($respondent) {
        // $respondent->last_send_at = date('Y-m-d');
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
      
      return response()
              ->json(['success' => 1, 'message' => 'Thank you for submitting your feedback.  We really appreciate your help in our journey to always improve the service we provide to you.']);
    } catch(\Exception $e) {
      return response()
              ->json(['success' => 0, 'message' => [
                'customMessages' => array(
                  'error.message' => 'Something went wrong. Please try again.'
                )
            ]]);
    }
  }

  public function success() {
    return view('survey.success');
  }
}

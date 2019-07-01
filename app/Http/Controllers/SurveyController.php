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
    $data = [];
    $step = $request->session()->get('step');
    $score = (int)$request->session()->get('score');

    if (!isset($inputs['one-time-code'])) {
      return view('survey.no-code');
    }

    $code = Code::where(['code' => $inputs['one-time-code']])->first();
    if (is_null($code)) {
      return view('survey.no-code');
    }

    if (!$code->active) {
      if ($step) {
        if ($score) {
          $data['score'] = $score;
        }
        return view('survey.step2', compact('inputs', 'data'));
      }
      return view('survey.expired');
    }

    return view('survey.index', compact('inputs'));
  }

  public function submit(Request $request) {
    if ($request->input('step') === "1") {
      $validator = Validator::make($request->all(), [
        'score' => 'required|numeric'
      ],[
        'score.required' => 'Please choose a response to the first question between 1 and 10.'
      ]);
    } else {
      $validator = Validator::make($request->all(), [
        'feedback' => 'required'
      ],[
        'feedback.required' => 'Please enter a valid feedback.'
      ]);
    }

    if ($validator->fails()) {
      return response()
        ->json(['success' => 0, 'message' => $validator]);
    }

    try {
      $reviewId = Review::generateUniqueId();
      $feedbackId = Feedback::generateUniqueId();
      $code = Code::where(['code' => $request->input('code')])->first();

      if (!$code->active && $request->input('step') === "1") {
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

      if ($request->input('step') === "1") {
        $review = Review::firstOrNew(['id' => $reviewId]);

        if ($request->input('anonymize_score') === '0') {
          $review->codes_id = $code->id;
        }
  
        $review->score = $request->input('score');

        // Save review
        $review->reviewed_at = date('Y-m-d H:i:s');
        $review->save();
      }
      
      if ($request->input('step') === 2 && $request->input('feedback')) {
        $feedback = Feedback::firstOrNew(['id' => $feedbackId]);
        if ($request->input('anonymize_feedback') === '0') {
          $feedback->codes_id = $code->id;
        }

        $feedback->feedback = $request->input('feedback');
        $feedback->reviewed_at = date('Y-m-d H:i:s');
        $feedback->save();
      }
  
      // Set code to inactive
      $code->active = false;
      $code->save();

      if ($request->input('step') === "1") {
        $request->session()->put('step', $code->code);
        $request->session()->put('score', $review->score);
      } else {
        $request->session()->pull('step', 'default');
        $request->session()->pull('score', 'default');
      }

      return response()
              ->json(['success' => 1, 'message' => 'Thank you for submitting your feedback. We really appreciate your help in our journey to always improve the service we provide to you.']);
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

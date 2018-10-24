<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Respondent;
use App\Models\Code;
use URL;

class MonthlySurvey extends Mailable
{
  use Queueable, SerializesModels;
  public $respondent;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(Respondent $respondent)
  {
    $this->respondent = $respondent;
    $this->buildUrl();
  }

  private function buildUrl() {
    $random_code = Code::generateUniqueCode();

    $current_code = Code::where(['respondents_id' => $this->respondent->id, 'active' => TRUE])->first();
    if (is_null($current_code)) {
      $code = Code::firstOrCreate(['code' => $random_code, 'respondents_id' => $this->respondent->id]);
    } else {
      $response['message'] = 'User currently has an active code.';
      $code = $current_code;
    }

    $this->respondent->survey_url = URL::to('/?ref=' . $code->code);    
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('emails.nps-survey');
  }
}

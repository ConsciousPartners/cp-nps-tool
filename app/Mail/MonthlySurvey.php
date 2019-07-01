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
    $code = Code::firstOrCreate(['code' => $random_code, 'respondents_id' => $this->respondent->id]);
    $this->respondent->survey_url = URL::to('/?one-time-code=' . $code->code);    
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject(env('MAIL_SUBJECT'))->view('emails.nps-survey');
  }
}

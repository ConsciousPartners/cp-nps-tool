<?php

namespace App\Listeners;

use App\Events\SendMonthlySurveyEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\MonthlySurvey;

class SendMonthlySurveyEventListener
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  SendMonthlySurveyEvent  $event
   * @return void
   */
  public function handle(SendMonthlySurveyEvent $event)
  {
    $respondent = $event->respondent;

    Mail::to($respondent->email)->send(new MonthlySurvey($respondent));
  }
}

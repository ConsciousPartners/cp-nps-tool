<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Respondent;

class SendMonthySurveyJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  protected $respondent;
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(Respondent $respondent)
  {
    $this->respondent = $respondent;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    dd($this->respondent);
  }
}

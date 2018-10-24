<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Respondent;
use App\Mail\MonthlySurvey;

class SendMonthlySurvey extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'survey:send-monthly';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
      parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $respondents = Respondent::where(['last_send_at' => NULL])
      ->orWhereRaw('`last_send_at` + INTERVAL 30 DAY < NOW()')
      ->get();

    if ($respondents) {
      foreach($respondents as $respondent) {
        Mail::to($respondent->email)->send(new MonthlySurvey($respondent));
      }
    }
  }
}

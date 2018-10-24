<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MailchimpApi\MailchimpApi;
use App\Models\Respondent;

class FetchNewMailchimpSubscribers extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mailchimp:fetch-subscribers';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command to fetch new subscribers from mailchimp api.';

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
  public function handle(MailchimpApi $mailchimp)
  {
    $members = $mailchimp->getMembers();

    foreach($members as $member) {
      $respondent = Respondent::firstOrNew(['email' => $member['email_address']]);
      if (!$respondent->exists) {
        $respondent->first_name = $member['merge_fields']['FNAME'];
        $respondent->last_name = $member['merge_fields']['LNAME'];
        $respondent->save();
      }
    }
  }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MailchimpApi\MailchimpApi;
use App\Models\Respondent;

class MailchimpController extends Controller
{
  public function fetch(Request $request, MailchimpApi $mailchimp)
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
    
    return redirect()
      ->back()
      ->with('message', 'Success fetching from mailchimp.');  
  }

  public function sendSurveys(Request $request)
  {
    try {
      \Artisan::call('survey:send-monthly');
      return redirect()
        ->back()
        ->with('message', 'Emails sent'); 
    } catch(\Exception $e) {
      return redirect()
      ->back()
      ->withErrors([$e->getMessage()]);      
    }
  }
}

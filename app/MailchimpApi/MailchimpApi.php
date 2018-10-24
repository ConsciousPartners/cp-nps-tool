<?php
namespace App\MailchimpApi;
use \DrewM\MailChimp\MailChimp;

class MailchimpApi {
  private $mailchimp;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->mailchimp = new MailChimp(env('MAILCHIMP_KEY'));
  }

  public function getMembers()
  {
    try {
      $result = $this->mailchimp->get('/lists/' . env('MAILCHIMP_LIST_ID') . '/members');
      return $result['members'];
    } catch (\Exceptoion $e) {
      \Log::alert($e->getMessage());
    }
  }
}
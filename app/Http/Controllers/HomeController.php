<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DrewM\MailChimp\MailChimp;

class HomeController extends Controller
{
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $respondent = \App\Models\Respondent::find(1);

        // return view('emails.nps-survey');
        return view('emails.nps-survey', compact('respondent'));
    }
}

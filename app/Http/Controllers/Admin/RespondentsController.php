<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Respondent;

class RespondentsController extends Controller
{
  public function index()
  {
    $respondents = Respondent::all();

    return view('admin.respondents.index', compact('respondents'));
  }

  public function create()
  {
    return view('admin.respondents.create');
  }

  public function store(Request $request)
  {
    try {
      $respondent = Respondent::firstOrNew(['email' => $request->input('email')]);
      if (!$respondent->exists) {
        $respondent->first_name = $request->input('first_name');
        $respondent->last_name = $request->input('last_name');
        $respondent->save();

        return redirect(route('admin::respondents::admin.respondents.index'))
          ->with('message', 'Added new respondent.');        
      } else {
        return redirect()
        ->back()
        ->withErrors(['This email already exists.'])
        ->withInput();   
      }

    } catch (\Exception $e) {
      return redirect()
      ->back()
      ->withErrors([$e->getMessage()])
      ->withInput();       
    }
  }
}

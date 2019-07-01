<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Respondent;
use App\Models\Code;
use URL;

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

        return redirect(route('admin::respondents.index'))
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

  public function destroy(Request $request, Respondent $respondent)
  {
    try {
      $item = Respondent::find($respondent->id);
      $item->delete();
      
      return redirect()
        ->back()
        ->with('message', 'Successfully deleted respondent.');
    } catch (\Exception $e) {
      return redirect()
        ->back()
        ->withErrors([$e->getMessage()])
        ->withInput();      
    }
  }

  public function getCode(Request $request, $id)
  {
    $response = [];
    try {
      $respondent = Respondent::find($id);
      if ($respondent) {
        $random_code = Code::generateUniqueCode();
        $code = Code::firstOrCreate(['code' => $random_code, 'respondents_id' => $respondent->id]);
        $response['url'] = URL::to('/?one-time-code=' . $code->code);

        return response()->json($response, 200);
      }
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}

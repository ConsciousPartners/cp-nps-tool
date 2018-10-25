<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::all();
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $item = Review::find($id);
        $item->delete();
        
        return redirect()
          ->back()
          ->with('message', 'Successfully deleted review.');
      } catch (\Exception $e) {
        return redirect()
          ->back()
          ->withErrors([$e->getMessage()])
          ->withInput();      
      }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Feedback;

class ReviewsController extends Controller
{
  public function index() {
    $reviews = Review::all();
    $feedbacks = Feedback::all();

    return view('admin.reviews.index', compact('reviews', 'feedbacks'));
  }
}

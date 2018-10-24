@extends('layouts.admin-base')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h2>Reviews</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Score</th>
            <th>Anonymous?</th>
          </tr>
        </thead>
        <tbody>
          @if (count($reviews) > 0)
          @foreach($reviews as $review)
          <tr>
            <td>{{ $review->score }}</td>
            <td>{{ (!$review->codes_id) ? 'Yes' : 'No' }}</td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="2">No results found</td>
          </tr>
          @endif
        </tbody>
      </table>


      <h2>Feedbacks</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Feedback</th>
            <th>Anonymous?</th>
          </tr>
        </thead>
        <tbody>
          @if (count($feedbacks) > 0)
          @foreach($feedbacks as $feedback)
          <tr>
            <td>{{ $feedback->feedback }}</td>
            <td>{{ (!$feedback->codes_id) ? 'Yes' : 'No' }}</td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="2">No results found</td>
          </tr>
          @endif
        </tbody>
      </table>      
    </div>
  </div>
</div>
@endsection
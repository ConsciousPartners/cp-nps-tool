@extends('layouts.admin-base')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <h2>Reviews</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Score</th>
            <th>Anonymous?</th>
            <th>Name</th>
            <th>Email</th>
            <th>Month</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if (count($reviews) > 0)
          @foreach($reviews as $review)
          <tr>
            <td>{{ $review->score }}</td>
            <td>
              {{ (!$review->codes_id) ? 'Yes' : 'No' }}
            </td>
            @if ($review->Code && $review->Code->Respondent)
              <td>{{ $review->Code->Respondent->first_name }} {{ $review->Code->Respondent->last_name }}</td>
              <td>{{ $review->Code->Respondent->email }}</td>
            @else
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            @endif
            <td>
              @if ($review->reviewed_at)
                <?php
                  $month = date('m', strtotime($review->reviewed_at));
                  $day = date('j', strtotime($review->reviewed_at));
                  $year = date('Y', strtotime($review->reviewed_at));
                ?>
                @if ($day <= 10)
                  {{ date('M', strtotime("-1 month",strtotime($review->reviewed_at))) }} {{ $year }}
                @else
                  {{ date('M', strtotime($review->reviewed_at)) }} {{ $year }}
                @endif
              @endif
            </td>
            <td>
              <form action="{{ route('admin::reviews.destroy', $review->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="5">No results found</td>
          </tr>
          @endif
        </tbody>
      </table>    
    </div>
  </div>
</div>
@endsection
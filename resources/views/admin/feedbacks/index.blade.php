@extends('layouts.admin-base')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <h2>Feedbacks</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Feedback</th>
            <th>Anonymous?</th>
            <th>Name</th>
            <th>Email</th>
            <th>Month</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if (count($feedbacks) > 0)
          @foreach($feedbacks as $feedback)
          <tr>
            <td>{{ $feedback->feedback }}</td>
            <td>
              {{ (!$feedback->Code) ? 'Yes' : 'No' }}
            </td>
            @if ($feedback->Code && $feedback->Code->Respondent)
              <td>{{ $feedback->Code->Respondent->first_name }} {{ $feedback->Code->Respondent->last_name }}</td>
              <td>{{ $feedback->Code->Respondent->email }}</td>
            @else
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            @endif
            <td>
              @if ($feedback->reviewed_at)
                <?php
                  $month = date('m', strtotime($feedback->reviewed_at));
                  $day = date('j', strtotime($feedback->reviewed_at));
                  $year = date('Y', strtotime($feedback->reviewed_at));
                ?>
                @if ($day <= 15)
                  {{ date('M', strtotime("-1 month",strtotime($feedback->reviewed_at))) }} {{ $year }}
                @else
                  {{ date('M', strtotime($feedback->reviewed_at)) }} {{ $year }}
                @endif
              @endif
            </td>            
            <td>
              <form action="{{ route('admin::feedbacks.destroy', $feedback->id) }}" method="POST">
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
@extends('layouts.admin-base')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <h1>Respondents</h1>  

      <div class="mb-5">
        <div class="row">
          <div class="col-md-6">
            <form method="POST" action="{{ route('admin::mailchimp::admin.mailchimp.fetch') }}">
              @csrf
              <a href="{{ route('admin::respondents.create') }}" class="btn btn-success">Add Respondent</a>
              <button type="submit" class="btn btn-info">Fetch from mailchimp</button>
            </form>
          </div>
          <div class="col-md-5 text-right">
            <form method="POST" action="{{ route('admin::mailchimp::admin.mailchimp.send-survey') }}">
              @csrf
              <button type="submit" class="btn btn-primary">Send surveys</button>
            </form>            
          </div>
        </div>
      </div>

      <table class="table table-striped">
        <thead>
          <tr>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Email</td>
            <td>Actions</td>
          </tr>
        </thead>
        <tbody>
          @foreach($respondents as $respondent)
          <tr>
            <td>{{ $respondent->first_name }}</td>
            <td>{{ $respondent->last_name }}</td>
            <td>{{ $respondent->email }}</td>
            <td>
              <form action="{{ route('admin::respondents.destroy', $respondent->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
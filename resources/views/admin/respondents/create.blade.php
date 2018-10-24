@extends('layouts.admin-base')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 off-md-3">
      <h1>Add Respondent</h1>  

      <form method="POST" action="{{ route('admin::respondents::admin.respondents.store') }}">
        @csrf
        <div class="form-group">
          <label for="">First Name</label>
          <input name="first_name" type="text" class="form-control" value="{{ old('first_name') }}" required />
        </div>
        <div class="form-group">
          <label for="">Last Name</label>
          <input name="last_name" type="text" class="form-control" value="{{ old('last_name') }}" required />
        </div>
        <div class="form-group">
          <label for="">Email</label>
          <input name="email" type="email" class="form-control" value="{{ old('email') }}" required />
        </div>        
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>

    </div>
  </div>
</div>
@endsection
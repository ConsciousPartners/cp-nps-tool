@extends('layouts.admin-base')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <h1>Respondents</h1>  

      <div class="mb-5">
        <div class="row">
          <div class="col-md-6">
            <a href="{{ route('admin::respondents.create') }}" class="btn btn-success">Add Respondent</a>
          </div>
          <div class="col-md-5 text-right">
            <form method="POST" action="#">
              @csrf
              <button type="submit" class="btn btn-primary disabled" disabled>Send surveys</button>
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
            <td width="180">
              <div class="button-actions">
                <button data-id="{{ $respondent->id }}" class="btn btn-sm btn-info btn-copy"><i class="fas fa-plus-square"></i> Get Link</button>
                <form action="{{ route('admin::respondents.destroy', $respondent->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input id="copyLinkInput" type="text" class="form-control" readonly />
        </div>
        <div class="copy">
          <button data-clipboard-target="#copyLinkInput" id="copyLinkButton" class="btn btn-primary"><i class="fas fa-copy"></i> Copy Link</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
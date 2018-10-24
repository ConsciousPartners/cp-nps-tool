@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h2>Generate for code user</h2>
      <div class="message" style="display:none;margin-bottom: 25px;"></div>
      <form id="generateForm" action="">
        <div class="form-group">
          <label for="">Enter email address</label>
          <input name="email_address" type="email" class="form-control" placeholder="johndoe@example.com" required />
        </div>
        <button type="button" class="btn btn-success">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection

@section('custom-scripts')
<script>
$(document).ready(function(){

  var $form = $('#generateForm');
  $form.find('button').on('click', function(e){
    e.preventDefault();
    var data = $form.serializeObject();

    axios.post('/generate', data)
    .then(function (response) {
      // handle success
      var $message = '';
      if (response.data.message) {
        $message += response.data.message + ' ';
      }
      $message += '<code>' + response.data.url + '</code>';

      $('.message').addClass('alert alert-success');
      $('.message').html($message);
      $('.message').show();
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    })
    .then(function () {
      // always executed
    });
  });

  $.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
      if (o[this.name] !== undefined) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || '');
      } else {
        o[this.name] = this.value || '';
      }
    });
    return o;
  };
});
</script>
@endsection
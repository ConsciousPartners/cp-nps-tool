@extends('layouts.app')

@section('header-scripts')
<script>
  window._cp_ref = "<?php echo isset($_GET['one-time-code']) ? $_GET['one-time-code'] : ''; ?>";
</script>
@endsection

@section('content')
<div class="container survey-page">

  @if ($errors->any())
    <div class="alert alert-danger">
      @foreach ($errors->all() as $error)
        {{ $error }}
      @endforeach
    </div>
  @endif

  <div class="survey-page--header">
    <h1>FEEDBACK SURVEY</h1>
  </div>
  <div class="survey-page--body">
    <form data-event-category="Form" data-event-action="NPSReplyComplete" data-event-label="<?php echo isset($_GET['one-time-code']) ? $_GET['one-time-code'] : ''; ?>" id="surveyForm" action="{{ URL::to('/survey/submit') }}" method="POST">
      @csrf
      <input type="hidden" name="code" value="{{ $inputs['one-time-code'] }}" />
      <input type="hidden" name="step" value="1">
      <div class="row">
        <div class="col-md-9">
          <h4>Considering your complete experience with our company, how likely would you be to recommend us to a friend or colleague?</h4>
        </div>
        <div class="col-md-3">
          <div class="box-anonymize text-center">
            <h5>Anonymize your Answer?</h5>
            <div class="box-anonymize--options">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="anonymize_score" id="inlineRadio1" value="1" checked>
                <label class="form-check-label" for="inlineRadio1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="anonymize_score" id="inlineRadio2" value="0">
                <label class="form-check-label" for="inlineRadio2">No</label>
              </div>              
            </div>
          </div>
        </div>
      </div>
      
      <div class="score-legend">
        <div class="row">
          <div class="col-6 text-left">◄   Very Unlikely</div>
          <div class="col-6 text-right">Very Likely   ►</div>
        </div>
      </div>

      <div id="score-radio">
        @for($i = 1; $i <= 10; $i++)
          <input id="score{{$i}}" name="score" type="radio" value="{{$i}}">
          <label for="score{{$i}}">{{$i}}</label>
        @endfor
      </div>

      <div class="box-sep"></div>

      <div class="text-center">
        <button type="submit" class="btn btn-custom btn-lg btn-primary">SUBMIT</button>
      </div>
    </form>

    <div class="text-center pt-3 pb-5">
      <p class="mb-0 disclaimer"><small>In order to help you feel comfortable, you have the option to anonymize each answer.  We do not log IP addresses or time of submissions, and all anonymous answers are randomly sorted so that we are not able to ascertain any information on who submitted what.</small></p>
    </div>

  </div>
</div>
@endsection

@section('custom-scripts')
<script>
$(document).ready(function(){
  var radios = $("#score-radio").radiosToSlider();
});
</script>
@endsection
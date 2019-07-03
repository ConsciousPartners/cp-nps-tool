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
    <p>Thank you for providing us that valuable feedback. We really appreciate it.</p>
  </div>
  <div class="survey-page--body">
    <form data-event-category="Form" data-event-action="NPSFeedbackComplete" data-event-label="<?php echo isset($_GET['one-time-code']) ? $_GET['one-time-code'] : ''; ?>" id="surveyForm" action="{{ URL::to('/survey/submit') }}" method="POST">
      @csrf
      <input type="hidden" name="code" value="{{ $inputs['one-time-code'] }}" />
      <input type="hidden" name="step" value="2">

      <div class="row mar-bot">
        <div class="col-md-9">
          @if(in_array($data['score'], [1,2,3,4,5,6]))
            <h4><span class="optional">(Optional)</span> We're sorry we weren't able to provide you with a better experience. We'd really like to improve that {{ $data['score'] }} in the future and we would be very grateful if you could quickly suggest one thing we could improve on.</h4>
          @endif
          @if (in_array($data['score'], [7,8,9]))
            <h4><span class="optional">(Optional)</span> We appreciate you rating us @if($data['score'] === 8) an @else a @endif {{ $data['score'] }}. However, we strive to be better and we'd still like to improve on that in the future. We would be very grateful if you could quickly suggest one thing we could improve on.</h4>
          @endif
          @if (in_array($data['score'], [10]))
            <h4><span class="optional">(Optional)</span> We're glad you enjoyed your experience working with us.  We're always looking to do better and we would be very grateful if you could quickly suggest one thing we could improve on.</h4>
          @endif
        </div>
        <div class="col-md-3">
          <div class="box-anonymize text-center">
            <h5>Anonymize your Answer?</h5>
            <div class="box-anonymize--options">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="anonymize_feedback" id="inlineRadio3" value="1">
                <label class="form-check-label" for="inlineRadio3">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="anonymize_feedback" id="inlineRadio4" value="0" checked>
                <label class="form-check-label" for="inlineRadio4">No</label>
              </div>              
            </div>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <textarea name="feedback" cols="30" rows="5" class="form-control"></textarea>
      </div>

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
@extends('layouts.app')

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
    <h2>Conscious partners monthly feedback survey</h2>

    <p>Your feedback is highly appreciated. Integer fringilla mauris scelerisque diam aliquam ultricies. Integer blandit sapien quis ornare vulputate. Nunc eros ligula, interdum semper accumsan dapibus, efficitur ac dolor. Morbi sit amet fermentum ligula, a dignissim lacus. Curabitur semper dapibus felis, at dignissim lectus convallis eget. Sed condimentum odio malesuada urna pulvinar interdum.</p>    
  </div>
  <div class="survey-page--body">
    <form action="{{ URL::to('/survey/submit') }}" method="POST">
      @csrf
      <input type="hidden" name="code" value="{{ $inputs['ref'] }}" />
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

      <div class="row mar-bot">
        <div class="col-md-9">
          <h4>Do you have any other feedback you would like to share on how we can make your experience with our company better? <span class="optional">(Optional)</span></h4>
        </div>
        <div class="col-md-3">
          <div class="box-anonymize text-center">
            <h5>Anonymize your Answer?</h5>
            <div class="box-anonymize--options">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="anonymize_feedback" id="inlineRadio3" value="1" checked>
                <label class="form-check-label" for="inlineRadio3">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="anonymize_feedback" id="inlineRadio4" value="0">
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
        <button class="btn btn-custom btn-lg btn-primary">SUBMIT</button>
      </div>
    </form>

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
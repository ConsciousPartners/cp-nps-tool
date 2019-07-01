import * as Toastr from 'toastr';
import ClipboardJS from 'clipboard';

$(document).ready(function(){
  if ($("#score-radio").length > 0) {
    var radios = $("#score-radio").radiosToSlider();
  }

  var $copyModal = $('#copyModal');
  var clipboard = new ClipboardJS('#copyLinkButton');

  $('.btn-copy').on('click', function(e){
    var respondentId = $(this).data('id');
    var _this = this;

    axios.post('/admin/respondents/' + respondentId + '/get-code', {})
    .then(function (response) {
      $copyModal.find('#copyLinkInput').val(response.data.url);
      $copyModal.modal();
    })
    .catch(function (error) {
      Toastr.warning('Something went wrong. Please try again.');
    });
  });

  clipboard.on('success', function(e){
    Toastr.success('Link copied!', 'Success!');
  });

  clipboard.on('error', function(e){
    Toastr.warning('Something went wrong. Please try again.');
  });

  $copyModal.on('hidden.bs.modal', function (e) {
    $copyModal.find('#copyLinkInput').val('');
  });

  var $surveyForm = $('#surveyForm');
  $surveyForm.find('button[type="submit"]').on('click', function(e){
    e.preventDefault();

    var data = $surveyForm.serializeObject();
    axios.post('/survey/submit', data)
    .then(function (response) {
      var message = '';
      if (response.data.success === 0) {
        for (var m in response.data.message.customMessages) {
          if (response.data.message.customMessages[m]) {
            message += response.data.message.customMessages[m] + "\n";
          }
        }
        Toastr.error(message);
      }

      if (response.data.success === 1) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ 
          event : 'globalEvent',
          eventCategory : $surveyForm.data('event-category'),
          eventAction : $surveyForm.data('event-action'),
          eventLabel : $surveyForm.data('event-label')
        });
        $surveyForm.find(":input").attr("disabled", true);
        if (radios) {
          for (var i in radios) {
            radios[i].setDisable();
          }
        }
        Toastr.success(response.data.message, 'Success!', { timeOut : 20000 });
        var url = window.location.href;
        setTimeout(function(){
          window.location.reload(false);
        }, 3000);
      }
    })
    .catch(function (error) {
      console.log(error);
      Toastr.warning('Something went wrong. Please try again.');
    });
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
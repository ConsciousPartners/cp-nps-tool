import * as Toastr from 'toastr';

$(document).ready(function(){
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
  })  
});
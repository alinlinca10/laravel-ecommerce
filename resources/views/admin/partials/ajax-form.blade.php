<script type="text/javascript">

var options = {
    target:        '.response',   // target element(s) to be updated with server response
    beforeSubmit:  showRequest,  // pre-submit callback
    success:       showResponse  // post-submit callback
};

// bind form using 'ajaxForm'
$('{!! $form !!}').ajaxForm(options);

// pre-submit callback
function showRequest(formData, jqForm, options) {
    $('.response').html('<div class="row mt-3 mb-3"><div class="col-md-12 text-center"><h4><i class="bi bi-spinner fa-spin"></i></h4></div></div>');
    return true;
}

// post-submit callback
function showResponse(responseText, statusText, xhr, $form)  {
    if($('.response').hasClass('hidden')) {
      $('.response').html(responseText);
      $('.response').removeClass('hidden');
    } else {
      $('.response').addClass('hidden');
    }
}
</script>

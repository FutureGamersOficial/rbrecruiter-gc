$("#jointype").on('change', function() {
    if ($(this).is(':checked')) {
      $(this).attr('value', '1');
    } else {
      $(this).attr('value', '0');
    }
});
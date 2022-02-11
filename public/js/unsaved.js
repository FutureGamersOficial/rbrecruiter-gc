// Load this on all pages requiring exit confirmation.
$(window).bind('beforeunload', function(){
  return "Are you sure you want to exit this page? You might have unsaved work.";
});
$( document ).ready(function() {
$('#cssmenu').prepend('<div id="bg-one"></div><div id="bg-two"></div><div id="bg-three"></div><div id="bg-four"></div>');
$( ".message" ).hide().fadeIn("500").click(function() {
  $( ".message" ).fadeOut( "slow" );
});
});
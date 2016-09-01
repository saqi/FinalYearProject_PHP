$(function(){
	
	var pp = $('#rmessage').pointPoint();
	
	// To destroy it, call the destroy method:
	// pp.destroyPointPoint(); 	
	
	$('.message').click(function(){
    pp.destroyPointPoint();
});
	
});
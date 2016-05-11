$(document).ready(function(){
  $('.slider').slick({
		autoplay: true,
		autoplaySpeed: 1000,
		arrows: false,
		vertical: true
  });
});

// Gif approval stuff
$(".gif-accepted").click(function(){
	alert("Accepted");
});

$(".gif-rejected").click(function(){
	alert("Narh, that one sucked anyways.");
});

// Chat stuff
$(".chat-closer").click(function(){
	$(".chat").hide();
});

$(".chat-trigger").click(function(){
	$(".chat").toggle();
});
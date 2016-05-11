$(function() {
	
	$(".slider").slick({
		vertical: true,
		adaptiveHeight: true,
		dots: false,
		arrows: false,
		centerMode: true,
		slidesToShow: 1,
		autoplay: true,
		autoplaySpeed: 0,
		speed: 9000,
		cssEase: 'linear'
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
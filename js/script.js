$(document).ready(function(){
  $('.slider').slick({
		autoplay: true,
		autoplaySpeed: 1000,
		arrows: false,
		vertical: true
  });
});

$(".gif-accepted").click(function(){
	alert("Accepted");
});

$(".gif-rejected").click(function(){
	alert("Narh, that one sucked anyways.");
});
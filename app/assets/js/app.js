$(document).ready(function(){
	//Back to top Scroll Function
	$(function(){
		$(document).on( 'scroll', function(){
			if ($(window).scrollTop() > 100) {
				$('.scroll-top-wrapper').addClass('show');
			} else {
				$('.scroll-top-wrapper').removeClass('show');
			}
		});		 
		$('.scroll-top-wrapper').on('click', scrollToTop);
	});
				 
	function scrollToTop() {
	  verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
	  element = $('body');
	  offset = element.offset();
	  offsetTop = offset.top;
	  $('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
	}

	//SCROLL MAIN
	var heightWindows = $(window).height();	
	if(heightWindows > 780){
		function relative_sticky(id, topSpacing){
		    if(!topSpacing){ var topSpacing = 0; }
			var el_top = parseFloat(document.getElementById(id).getBoundingClientRect().top);
			el_top = el_top - parseFloat(document.getElementById(id).style.top);
			el_top = el_top * (-1);
			el_top = el_top + topSpacing;
			if(el_top > 0){
					document.getElementById(id).style.top = el_top + "px";
			} else{
					document.getElementById(id).style.top = "0px";
			}
		}
					
		window.onscroll = function(){
					relative_sticky("sidebarRight", 58);
					relative_sticky("sidebarLeft", 58);
		}
	}else if(heightWindows > 650 && heightWindows < 780){
		$(function() {											
				var offset = $("#sidebarLeft").offset();
				var resultScroll = heightWindows - (heightWindows/10);
				var topPadding = - (heightWindows - resultScroll) + 25;			
				$(window).scroll(function() {
					if ($(window).scrollTop() > offset.top) {										
						$("#sidebarLeft").stop().animate({
							marginTop: $(window).scrollTop() - offset.top + topPadding
						});										
					}else {
						$("#sidebarLeft").stop().animate({
							marginTop: 0
						});
					};
				});
		});
					
		$(function() {
				var offset = $("#sidebarRight").offset();
				var resultScroll = heightWindows - (heightWindows/10);
				var topPadding = - (heightWindows - resultScroll) + 25;					
				$(window).scroll(function() {
					if ($(window).scrollTop() > offset.top) {										
						$("#sidebarRight").stop().animate({
							marginTop: $(window).scrollTop() - offset.top + topPadding
						});										
					}else {
						$("#sidebarRight").stop().animate({
							marginTop: 0
						});
					};
				});						
		});
	}else if(heightWindows > 600 && heightWindows < 650){
		$(function() {
				var offset = $("#sidebarLeft").offset();
				var resultScroll = heightWindows - (heightWindows/10);
				var topPadding = - (heightWindows - resultScroll) - 15;			
				$(window).scroll(function() {
					if ($(window).scrollTop() > offset.top) {
						$("#sidebarLeft").stop().animate({
							marginTop: $(window).scrollTop() - offset.top + topPadding
						});																		
					}else {
						$("#sidebarLeft").stop().animate({
							marginTop: 0
						});
					};
				});
		});
		$(function() {
				var offset = $("#sidebarRight").offset();
				var resultScroll = heightWindows - (heightWindows/10);
				var topPadding =  - (heightWindows - resultScroll) - 15;
				$(window).scroll(function() {
					if ($(window).scrollTop() > offset.top) {																		
						$("#sidebarRight").stop().animate({
							marginTop: $(window).scrollTop() - offset.top + topPadding
						});										
					}else {
						$("#sidebarRight").stop().animate({
							marginTop: 0
						});
					};
				});
		});
	}else{
		$(function() {
				var offset = $("#sidebarLeft").offset();
				var resultScroll = heightWindows - (heightWindows/10);
				var topPadding = - (heightWindows - resultScroll) - 36;
				$(window).scroll(function() {
					if ($(window).scrollTop() > offset.top) {
							$("#sidebarLeft").stop().animate({
								marginTop: $(window).scrollTop() - offset.top + topPadding
							});
					}else {
							$("#sidebarLeft").stop().animate({
								marginTop: 0
							});
					};
				});
		});
					
		$(function() {
				var offset = $("#sidebarRight").offset();
				var resultScroll = heightWindows - (heightWindows/10);
				var topPadding =  - (heightWindows - resultScroll) - 36;
				$(window).scroll(function() {
					if ($(window).scrollTop() > offset.top) {															$("#sidebarRight").stop().animate({
							marginTop: $(window).scrollTop() - offset.top + topPadding									});
					}else {
						$("#sidebarRight").stop().animate({
							marginTop: 0
						});
					};
				});
		});
	}
});
(function(e){"use strict";var t="ScrollIt",n="1.0.3";var r={upKey:38,downKey:40,easing:"linear",scrollTime:600,activeClass:"active",onPageChange:null,topOffset:0};e.scrollIt=function(t){var n=e.extend(r,t),i=0,s=e("[data-scroll-index]:last").attr("data-scroll-index");var o=function(t){if(t<0||t>s)return;var r=e("[data-scroll-index="+t+"]").offset().top+n.topOffset+1;e("html,body").animate({scrollTop:r,easing:n.easing},n.scrollTime)};var u=function(t){var n=e(t.target).closest("[data-scroll-nav]").attr("data-scroll-nav")||e(t.target).closest("[data-scroll-goto]").attr("data-scroll-goto");o(parseInt(n))};var a=function(t){var r=t.which;if(e("html,body").is(":animated")&&(r==n.upKey||r==n.downKey)){return false}if(r==n.upKey&&i>0){o(parseInt(i)-1);return false}else if(r==n.downKey&&i<s){o(parseInt(i)+1);return false}return true};var f=function(t){if(n.onPageChange&&t&&i!=t)n.onPageChange(t);i=t;e("[data-scroll-nav]").removeClass(n.activeClass);e("[data-scroll-nav="+t+"]").addClass(n.activeClass)};var l=function(){var t=e(window).scrollTop();var r=e("[data-scroll-index]").filter(function(r,i){return t>=e(i).offset().top+n.topOffset&&t<e(i).offset().top+n.topOffset+e(i).outerHeight()});var i=r.first().attr("data-scroll-index");f(i)};e(window).on("scroll",l).scroll();e(window).on("keydown",a);e("body").on("click","[data-scroll-nav], [data-scroll-goto]",function(e){e.preventDefault();u(e)})}})(jQuery)

function scrollFunction(){
	var height = $(window).scrollTop();
	if(height >= 100){

	}
}
function resizeFunction(){
	var bannerHeight = $('header.banner').height();
	var windowHeight = $(window).height();
	var newHeight = windowHeight-bannerHeight;
	$(".flexslider").height(newHeight);
	$(".slide").height(newHeight);
	$.each($(".slidecontent"), function(evt){
		var oheight = $(this).height();
		var newheight = -( oheight/2)+70;
		$(this).css({"marginTop" : newheight+"px"});
	});
}
//var scrolldown = _.throttle(scrollFunction, 100);
//var slowdown = _.throttle(resizeFunction, 100);
//$(window).resize(slowdown);
//$(window).scroll(scrolldown);


function openClose(evt){
	evt.stopPropagation();
	$body.toggle(0);
	$target.toggleClass('active');
}

function mobileNav(){
	// check for mobile nav element. Exit if not present
	if(!document.getElementById('mainnavmobile')){ return false;}

	$icon = $("#mobile-icon");
	$target = $("#mainnavmobile nav");

	$target.after("<div id='drop'>");
	$body = $("#drop");
	$body.css({
		'position' : 'fixed',
		'zIndex' : 200,
		'display': 'none'
	});
	
	$body.height($(window).height());
	$body.width($(window).width());

	$icon.on('click touch', openClose);
	$body.on('click touch', openClose);

}


function dropdownMenu(){
	

	var mouse_pos = false;

	$menus = $("#mainnav ul.dropdown-menu");

	$(document).on('click touchstart',function(evt){
		$menus.removeClass('active');
		//evt.preventPropagation();	
	});

	// get all instances of the drop downs.
	$menus.each(function(key, val){
		$this = $(this);
		$parent = $this.parent('li');

		var px = $parent.offset().top + 30;
		var py = $parent.offset().left;
		var pw = py + 24;

		$this.appendTo("body");
		$this.css({
			position: 'absolute',
			display: 'block',
			top : px + "px",
			left : pw + "px"
		});
		$this.addClass("menu"+key);
		$this.add($parent).on('click touchstart', function(evt){
			evt.stopPropagation();
		});

		$parent.on('click touchstart', function(evt){
			evt.preventDefault();
			var item = $(".menu"+key);
			$menus.not(item).removeClass("active");
			if(item.hasClass('active')) {
				item.removeClass('active');
			}else{
				item.addClass('active');
			}
		});
	});
}



function init(){
	// base jquery mod prep
$.scrollIt();
	if(!document.getElementById('mainnavmobile')){
		
//	$("#menu-primary-navigation").clone().attr('id', 'stickymenu').appendTo('body');
//	$stickymenu = $("#stickymenu");
//	console.log($stickymenu);
	}

	//resizeFunction();
	mobileNav();
	if(!document.getElementById('mainnavmobile')){
		dropdownMenu();
	}
}

$(function(){
	init();
	
	$(".flexslider").flexslider({
		selector: ".slides > div.slide",
		useCSS: true,
		animationSpeed: 400,
		directionNav: false
	});
	
});
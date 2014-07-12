
/*
 Ridiculously Responsive Social Sharing Buttons
 Team: @dbox, @seagoat
 Site: http://www.kurtnoble.com/labs/rrssb
 Twitter: @therealkni

        ___           ___
       /__/|         /__/\        ___
      |  |:|         \  \:\      /  /\
      |  |:|          \  \:\    /  /:/
    __|  |:|      _____\__\:\  /__/::\
   /__/\_|:|____ /__/::::::::\ \__\/\:\__
   \  \:\/:::::/ \  \:\~~\~~\/    \  \:\/\
    \  \::/~~~~   \  \:\  ~~~      \__\::/
     \  \:\        \  \:\          /__/:/
      \  \:\        \  \:\         \__\/
       \__\/         \__\/
*/


;(function(window, jQuery, undefined) {
	'use strict';


	var popupCenter = function(url, title, w, h) {
		// Fixes dual-screen position                         Most browsers      Firefox
		var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

		var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
		var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

		var left = ((width / 2) - (w / 2)) + dualScreenLeft;
		var top = ((height / 3) - (h / 3)) + dualScreenTop;

		var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

		// Puts focus on the newWindow
		if (window.focus) {
			newWindow.focus();
		}
	};

	var waitForFinalEvent = (function () {
		var timers = {};
		return function (callback, ms, uniqueId) {
			if (!uniqueId) {
				uniqueId = "Don't call this twice without a uniqueId";
			}
			if (timers[uniqueId]) {
				clearTimeout (timers[uniqueId]);
			}
			timers[uniqueId] = setTimeout(callback, ms);
		};
	})();

	/*
	 * Event listners
	 */

	jQuery('.rrssb-buttons a.popup').on('click', function(e){
		var _this = jQuery(this);
		popupCenter(_this.attr('href'), _this.find('.text').html(), 580, 470);
		e.preventDefault();
	});


})(window, jQuery);

/*
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
*/
function scrollFunction(){

	var height = $(window).scrollTop();
	if(height >= 100){
	$stickymenu.addClass('fixed');
	}else{
	$stickymenu.removeClass("fixed");
	}
}

var scrolldown = _.throttle(scrollFunction, 100);
var slowdown = _.throttle(resizeFunction, 100);
$(window).resize(slowdown);
$(window).scroll(scrolldown);


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
	if(!document.getElementById('mainnavmobile')){ 
	$("#menu-primary-navigation").clone().attr('id', 'stickymenu').appendTo('body');
	$stickymenu = $("#stickymenu");
	}

//	resizeFunction();
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
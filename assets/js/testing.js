
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

var buttonFilter = {
  
  // Declare any variables we will need as properties of the object
  
  $filters: null,
  $reset: null,
  groups: [],
  outputArray: [],
  outputString: '',
  
  // The "init" method will run on document ready and cache any jQuery objects we will need.
  
  init: function(){
    var self = this; // As a best practice, in each method we will asign "this" to the variable "self" so that it remains scope-agnostic. We will use it to refer to the parent "buttonFilter" object so that we can share methods and properties between all parts of the object.
    
    self.$filters = $('#filters');
    self.$reset = $('#reset');
    self.$container = $('#mixincontainer');
    
    self.$filters.find('ul').each(function(){
   //   console.log($(this).find('.filter'));
      self.groups.push({
        $buttons: $(this).find('.filter'),
        active: ''
      });
    });
    //console.log(self.groups);
    self.bindHandlers();
  },
  
  // The "bindHandlers" method will listen for whenever a button is clicked. 
  
  bindHandlers: function(){
    var self = this;
    // Handle filter clicks
    
    self.$filters.on('click', '.filter', function(e){
      e.preventDefault();
      
      var $button = $(this);
      
     // console.log($button);
      // If the button is active, remove the active class, else make active and deactivate others.
      if( $button.hasClass('active')){
		$button.removeClass('active');
      }else{
		$button.parent('li').parent('ul').find('.filter').removeClass('active');
		$button.addClass('active');

		

      }
      self.parseFilters();
    });
    
    // Handle reset click
    /*
    self.$reset.on('click', function(e){
      e.preventDefault();
      self.$filters.find('.filter').removeClass('active');
      self.parseFilters();
    });
*/
  },
  
  // The parseFilters method checks which filters are active in each group:
  
  parseFilters: function(){
    var self = this;
    // loop through each filter group and grab the active filter from each one.
    for(var i = 0, group; group = self.groups[i]; i++){
		//console.log("parse " + i);
		group.active = group.$buttons.filter('.active').attr('data-filter') || '';
    }
    self.concatenate();
  },
  
  // The "concatenate" method will crawl through each group, concatenating filters as desired:
  
  concatenate: function(){
    var self = this;
    
    self.outputString = ''; // Reset output string
    for(var i = 0, group; group = self.groups[i]; i++){
      self.outputString += group.active;
    }
    // If the output string is empty, show all rather than none:
    
    var $datefilter = $("#date-filter");



    if(self.outputString.indexOf('date')){
    	$datefilter.removeClass();
    	var count = self.outputString.indexOf('date');
    	var newclass = self.outputString.substring(count);
    	$datefilter.addClass("f"+newclass);
    }

	if(!self.outputString.length){
		self.outputString = 'all';
	}
  
    // ^ we can check the console here to take a look at the filter string that is produced
    
    // Send the output string to MixItUp via the 'filter' method:
    
		if(self.$container.mixItUp('isLoaded')){
			self.$container.mixItUp('filter', self.outputString);
		}
	}
};


function collapseSystem(){
	var sections = $(".mix");
	$("<div class='uparrow'>").appendTo(sections).on('click touch', function(){
		$this = $(this);
		if($this.hasClass("closed") ){
			$this.removeClass("closed");
			$this.siblings('.eventdescription').find('.eventextra').removeClass('closed');
		}else{
			$this.addClass("closed");
			$this.siblings('.eventdescription').find('.eventextra').addClass('closed');
		}
	});
	var allitems = $(".uparrow, .eventextra");
	$("#collapseall").on('click touchstart', function(evt){
		evt.preventDefault();
		allitems.addClass('closed');
		$("#extendall").removeClass('active');
		$(this).addClass('active');
	});
	$("#extendall").on('click touchstart', function(evt){
		evt.preventDefault();
		allitems.removeClass('closed');
		$("#collapseall").removeClass('active');
		$(this).addClass('active');

	});

}

function setupSchedule(){

	buttonFilter.init();
	collapseSystem();

	$('#mixincontainer').mixItUp({
    controls: {
		enable : false
    },
    layout:{
    	display: 'block'
    },
    callbacks: {
      onMixFail: function(){
		console.log("failed..");
      }
    }
  });
}

function searchBtn(){
	$btn = $("li.searchbtn a");
	$form = $("#searchform");



	$btn.add($form).on('click touchstart',function(evt){
		evt.stopPropagation();
	});
	$btn.on('click touchstart', function(evt){
		evt.preventDefault();
		$this = $(this);
		
		$this.toggleClass('active');
		$form.toggleClass('active');
		console.log($form.find("input"));
		$form.find("input").focus();
		// check for modernizr touch
		if($form.hasClass("active")){
			//$form.find("input").blur();
		}

		$(document).on('click touchstart',function(evt){
			$form.removeClass('active');	
			$this.removeClass('active');	
		});

	});
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

function fullLinking(n){
	var link = n.find('a');
	link.on('click touchstart',function(evt){
		evt.preventDefault();
	});

	n.on('click touchend', function(){
		var newlink = $(this).find('a');
		var url = newlink.attr('href');
		location.href = url;
	});
}

function init(){
	// base jquery mod prep
	if(!document.getElementById('mainnavmobile')){ 
	$("#menu-primary-navigation").clone().attr('id', 'stickymenu').appendTo('body');
	$stickymenu = $("#stickymenu");
	}

	resizeFunction();
	mobileNav();
	searchBtn();
	setupSchedule();
	if(!document.getElementById('mainnavmobile')){ 
		dropdownMenu();
	}
	fullLinking($('.news-cta'));
}

$(function(){

	init();
	
	$(".flexslider").flexslider({
		selector: ".slides > div.slide",
		useCSS: true,
		animationSpeed: 400,
		directionNav: false
	});

	$("#lineuplist").mixItUp({
		selectors : {
			target : 'li.act'
		}
	});

});
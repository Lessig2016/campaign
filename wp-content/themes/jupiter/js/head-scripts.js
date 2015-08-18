// New namespace for refactoring old scripts
ABB = window.ABB || {};

JP = window.JP || {};
JP.State = window.JP.State || {};;(function() {
	'use strict';

	JP.State = {
		hashScrolled : false
	};
	
})();;(function($) {
	'use strict';

	// broken by changes to theme
	function headerHeight() {
		var $header = $('#mk-header'),
			height = 0;

		if(!$.exists('.mk-vm-menuwrapper') && $header.attr('data-sticky-height')) {
			height = parseInt($header.attr('data-sticky-height'));
  		}

  		if( ($(window).width() <= mk_responsive_nav_width)
  		 || ($header.attr('data-sticky-style') === 'lazy')
  		){
		  	height = 0;
		}

		return (abb.modules.theme_header.adminHeight() + height - 1);
	}




	// Scroll top on very start if link has hash
	var loc = window.location,
		url = loc.origin + loc.pathname,
		hash = loc.hash;
		hash = hash.replace('#', '');

	function windowTop() {
		window.scrollTo(0, 0);		
	}

	// Assign hash to corresponding DOM element and execute smooth scroll when page loads
	function scrollToHash() {
		var $target = $('#' + hash),
			offset = $target.offset().top;

		// calculate directly; theme changes broke headerHeight()
		offset = offset - $('#header').outerHeight();
		console.log(offset);

		setTimeout(function() {
			$('html, body').animate({
				scrollTop: offset
				}, {
		  		duration: 1200,
		  		easing: "easeInOutExpo"
			});
	  	}, 500);
	}


	if(hash.length && hash.substring(1).length) {
		setTimeout(windowTop, 1); 
		$(window).load(function() {
			setTimeout(scrollToHash, 1000) 
		});
		// clear to prevent default bevaviour as window scrtollTo seems not bulletproof
		loc.hash = ''; // for older browsers
		window.history.pushState( { path:url }, '', url);
	}

})(jQuery);

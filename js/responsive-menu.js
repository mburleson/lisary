jQuery(document).ready(function($) {

  $("#menu-secondary-navigation").before('<div id="secondary-menu-icon"></div>');
  $("#secondary-menu-icon").click(function() {
		$(".menu-secondary").slideToggle();
	});
	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$(".menu-secondary").removeAttr("style");
		}
	});
	
});
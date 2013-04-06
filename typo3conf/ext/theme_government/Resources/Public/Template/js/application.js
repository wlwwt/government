!function ($) {
	$(function(){
		
		var $window = $(window)
		
		// side bar
		setTimeout(function () {
		  $('.bs-docs-sidenav').affix({
			offset: {
			  top: function () { return $window.width() <= 980 ? 290 : 200}
			, bottom: 270
			}
		  })
		}, 100);
		
		$('.splitlist').easyListSplitter({ colNumber: 2 });
		
	})
}(window.jQuery)

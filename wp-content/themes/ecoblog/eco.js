
jQuery(document).ready(function ($) {

	jQuery.isset = function(name) {
		return (typeof(window[name]) !== 'undefined') ? true : false;
	};

	// try to auto-resize large blog post images so that they don't overflow
	if($.isset('ide_img_resize') && ide_img_resize) {
		$('.widget_links img').each(function() {
			$(this).parent().parent().parent().addClass('widgetbanners');
		});				

		$('.post .text').each(function() {
			var maxWidth = $(this).outerWidth();
			var maxHeight = $(this).outerHeight();

			$(this).find('img').each(function() {
			
				var width = $(this).width();
				var height = $(this).height();

				var ratio = height / width;
				if(width >= maxWidth){
					width = maxWidth;
					height = width * ratio;
				} else if(height >= maxHeight){
					height = maxHeight;
					width = height / ratio;
				}
				
				$(this).css('width', width);
				$(this).css('height', height);
			});
		});
	}
});
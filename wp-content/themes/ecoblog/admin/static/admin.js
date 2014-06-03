/*
	tinyTabs (c) iDesignEco, 2010
*/
jQuery(document).ready(function($) {	
	var tinyTabs = {
	
		options: {
			anchor: true,
			target: '',
			section: 'section',
			tabs: 'tabs',
			title: 'title',
			hide_title: false,
			default_slide: 0
		},
		// activate a tab
		activate: function(section_id) {
			this.reset();
			
			if($(this.tabs).find('.tab_' + section_id).length == 0) return false;
			
			$(this.tabs).find('.tab_' + section_id).addClass('sel');
			$(this.options.target + ' #' +section_id).show();
			
			if(this.options.anchor) {
				document.location.href = '#_' + section_id;
			}
			
			return true;
		},
		// reset all tabs
		reset: function() {
			$(this.options.target).parent().find('li').each(function() {
				$(this).removeClass('sel');
			});
			
			// hide all sections
			$(this.options.target).find('.'+this.options.section).hide();
		},
		
		// ________________________________________________________
			
		create: function(options) {
			this.options = $.fn.extend( {}, this.options, options );
			// create tabs
			var tabs = $('<ul>').attr('class', this.options.tabs);	this.tabs = tabs;
			$(this.options.target).before(tabs);
			
			// create tabs, attach events to them
			$(this.options.target + ' .' + this.options.section).each(function() {
				var section = $(this);
				var section_id = $(this).attr('id');
				var h = $(this).find('.title:first');
					// hide title?
					tinyTabs.options.hide_title ? $(h).hide() : null;
					
				var title = $(h).html();
				$(tabs).append(
					$('<li>').attr('class', 'tab_' + section_id).append(
						$('<a>').html(title).attr('href', '#_'+ section_id ).click(function() {
							tinyTabs.activate(section_id);
							return tinyTabs.options.anchor;
						})
					)
				);
				
			});
			
			// is anchoring enabled?
			var href = document.location.href.split('#')[1];
			if(href) href = href.substr(1, href.length);
			
				if(this.options.anchor && href && this.activate(href)) {
				} else {
					$(tabs).find('li:eq('+ this.options.default_slide +') a').click();
				}			
				
		}
	};
	
	tinyTabs.create({
		target: '#ide_admin .ide_form', 	// where to look
		anchor: true,	// attach to page anchors?
		'hide_title' : true
	});
	
	$('.ide_form').submit(function() {
		if(document.location.href.split('#')[1]) {
			$('.ide_form')[0].action = '#'+document.location.href.split('#')[1];
		}
	});
	
	setTimeout(function() {
		$('.msg').slideUp();
	}, 3000);
	
	// video button
	var vid_button = $('#bt_ecovideo').val();
	$('#bt_ecovideo').click(function() {
		$('#ecovideo').html('<iframe src="http://idesigneco.com/wp_pub.php?id=theme_video&amp;theme='+$('#ecovideo').attr('title')+'" frameborder="0"></iframe>');
		$('#ecovideo').toggle();
		return false;
	});
	
});
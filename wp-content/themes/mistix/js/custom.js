// Superfish Menu

jQuery(document).ready(function(){
	jQuery('.menu').superfish({
            delay:      	0,                           
            animation:   {opacity:'show',height:'show'}, 
            speed:       300,                         
            autoArrows:  false,                         
            dropShadows: false                            
	 });
});

	
jQuery(document).ready(function(){
//<![CDATA[
jQuery(".zoom a").append("<span></span>");
//]]>
/*jQuery(".zoom img, .widget-pics img, .widgett img, .flickr_badge_image img, .blogimg img ").hover(function(){
jQuery(this).fadeTo(700, 0.5); 
},function(){
jQuery(this).fadeTo(700, 1.0); 
	});*/
});

jQuery(document).ready(function(){
jQuery(".gallery a").attr("rel", "lightbox[gallery]");

});

jQuery(document).ready(function(){
	jQuery(function() {
		jQuery( ".accordion" ).accordion({
			autoHeight: false,
			navigation: true
		});
	});
	jQuery(function() {
		jQuery( ".progressbar" ).progressbar();
	});

});
function loadprety(){

jQuery(".gallery a").attr("rel", "lightbox[gallery]").prettyPhoto({theme:'light_rounded',overlay_gallery: false,show_title: false});
}
				
jQuery(document).ready(function () {
jQuery(".carousel").jCarouselLite({
    btnNext: ".next",
    btnPrev: ".prev",
	easing: "linear",
	speed: 100,
	visible: 3,
	scroll: 3
	});
});	

jQuery(document).ready(function(){	
	
	jQuery('.showpostload').hide();
	jQuery('.showpostpostcontent').hide();
	jQuery('.closehomeshow').hide();
	jQuery('.click').click(function() {
	var id = jQuery(this).attr("id");
	var url = jQuery('#root').attr("href");
	var invariable = id.split('_');

	jQuery('html, body').animate({scrollTop:670}, 400);
	if(jQuery('.blogpost').is(":visible")){
		var oldheight = jQuery('.showpostpostcontent').height();
		jQuery('.showpostpostcontent').fadeOut(200);	
		jQuery('.showpostpostcontent').empty();
		jQuery('.closehomeshow').fadeOut(200);		
		jQuery('.showpostload').delay(200).fadeIn(200);
		if(oldheight > 500){
			var heightnew = oldheight - 500;
			jQuery('#showpost').delay(300).animate({"height": "-="+heightnew+"px"}, 500);	
		}		
		if(oldheight < 500){
			var heightnew = 500 - oldheight ;
			jQuery('#showpost').delay(300).animate({"height": "+="+heightnew +"px"}, 500);	
		}
		jQuery('.showpostpostcontent').load(url+'/single_home.php',{ 'id': invariable[1], 'type': invariable[0] } ,function () {
		var script = 'http://s7.addthis.com/js/250/addthis_widget.js#domready=1';
		if (window.addthis){
			window.addthis = null;
		}
		jQuery.getScript( script );

		jQuery('.posttext img').imagesLoaded(function () {
			height = jQuery('#showpostpostcontent').height();
			if(height >500) {
				heightnew = height - 500;
				jQuery('#showpost').animate({"height": "+="+heightnew+"px"}, 500);
			}
			if(height < 500) {
				heightnew =  500 - height;
				jQuery('#showpost').animate({"height": "-="+heightnew+"px"}, 500);
			}

			jQuery('.showpostload').fadeOut(600);
			jQuery('.showpostpostcontent').delay(700).fadeIn(200);
			jQuery('.closehomeshow').delay(700).fadeIn(200);
			loadprety();
			} );
		} );
	}
	else{
		var height = 0;
		jQuery('#showpost').animate({"height": "+=500px"}, 500);
		jQuery('.showpostload').fadeIn(200);
		jQuery('#remove').delay(500).fadeOut(200);	
		jQuery('#showpost').animate({"margin-top": "-=40px"}, 500);		
		jQuery('#showpostpostcontent').load(url+'/single_home.php',{ 'id': invariable[1], 'type': invariable[0] } ,function () {
		var script = 'http://s7.addthis.com/js/250/addthis_widget.js#domready=1';
		if (window.addthis){
			window.addthis = null;
		}
		jQuery.getScript( script );

		jQuery('.posttext img').imagesLoaded(function () {
			height = jQuery('#showpostpostcontent').height();
			if(height > 500) {
				var newheight = height - 500;
				jQuery('#showpost').animate({"height": "+="+newheight+"px"}, 500);
			}
			if(height < 500) {
				var newheight =  500 - height;
				jQuery('#showpost').animate({"height": "-="+newheight+"px"}, 500);
			}
			jQuery('.showpostload').fadeOut(500);
			jQuery('.showpostpostcontent').delay(600).fadeIn(200);
			jQuery('.closehomeshow').delay(600).fadeIn(200);	
			//loadprety()			
		}) 

		});

	}

	});
	
	jQuery('.closehomeshow').click(function() {
		var height = jQuery('#showpost').height()
		jQuery('.showpostpostcontent').fadeOut(200);
		jQuery('.closehomeshow').fadeOut(200);	
		jQuery('#showpost').animate({"height": "-="+height+"px"}, 750);
		jQuery('#showpost').delay(0).animate({"margin-top": "+=40px"}, 500);		
		jQuery('#remove').delay(1000).fadeIn(200);		
	});	
	

	
jQuery('.image').each(function(index,el){
          
       //find this link's child image element
      var img = jQuery(this).find('img');
	  var loading = jQuery(this).children('div');
      //hide the image and attach the load event handler
	  jQuery('.overlink').hide();
	  jQuery('.overgallery').hide();
	  jQuery('.overvideo').hide();
	  jQuery('.overdefult').hide();	  
	  jQuery('.overport').hide();	  
      jQuery(img).hide();
	  jQuery(window).load(function () {
            //remove the link's "loading" classname
            //loading.removeClass('loading');
			jQuery('.one_fourth').find('.loading').attr('class', '');
			jQuery('.item').find('.loading').attr('class', '');
			jQuery('.item4').find('.loading').attr('class', '');
            //show the loaded image
           jQuery(img).fadeIn();
		   var height = img.parents('.one_fifth').height() ;
		   height = height + 10;
		   img.parents('.one_fifth').css("height", height)
		   jQuery('#homeRecent').isotope( 'reLayout');
		   jQuery('.overlink').show();
		  jQuery('.overgallery').show();
		  jQuery('.overvideo').show();
		  jQuery('.overdefult').show();	  
		  jQuery('.overport').show();	  
      })

	 /*if ( jQuery.browser.msie || jQuery.browser.mozilla ) {
	   jQuery(img).delay(500).fadeIn();
		loading.delay(2500).removeClass('loading')

	}*/
	//loading.delay(1500).removeClass('loading');
	//jQuery(img).delay(1550).fadeIn();
	});
});


jQuery(document).ready(function(){	
	jQuery(window).load(function () {
		jQuery('.slider-item .loading').removeClass('loading');
		})
});

jQuery(document).ready(function(){	
	jQuery('.blogpostcategory').each(function(index,el){
			  
		   //find this link's child image element
		  var iframe = jQuery(this).find('iframe');
		  var loading = jQuery(this).children('div');
		  //hide the image and attach the load event handler
		  jQuery(iframe).hide();
		  jQuery(window).load(function () {
			   
				//remove the link's "loading" classname
				loading.removeClass('loading');
				
				//show the loaded image
			   jQuery(iframe).fadeIn();
		  })
	});
});



			
jQuery(document).ready(function() {	

	jQuery(".toggle_container").hide(); 

	jQuery("h2.trigger").click(function(){
		jQuery(this).toggleClass("active").next().slideToggle("slow");
	});
});	

jQuery(document).ready(function(){	
	jQuery(function() {
	jQuery(".tabs").tabs(".panes > div");
	});
	
	
});

jQuery(document).ready(function(){	
	function getCookie(c_name)
	{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
		{
		return unescape(y);
		}
	  }
	}

	var notification=getCookie("pmcnotification")
	if(notification == "close"){
		jQuery('#close').attr('class','open');
		jQuery(".notification").hide();
		jQuery("#logo").animate({"top": "-=26px"}, "medium");
		jQuery(".menu-header").animate({"top": "-=26px"}, "medium");

		jQuery("#headerwrap").animate({"height": "-=26px"}, "medium");				
	}
	
	jQuery('#close').click(function() {
	jQuery(".notification").animate({height:'toggle'},250);
	if(jQuery('#close').hasClass('close')){
		jQuery('#close').slideUp(0)
		   .delay(0)
		   .queue(function(next) { jQuery(this).attr('class','open'); next(); })
		   .delay(0)
		   .slideDown(250);
			document.cookie="pmcnotification=close;path=/";
			jQuery("#logo").animate({"top": "-=26px"}, "medium");
			jQuery(".menu-header").animate({"top": "-=26px"}, "medium");


			
			jQuery("#headerwrap").animate({"height": "-=26px"}, "medium");					
	}
	else{
		jQuery('#close').fadeOut(200)
		   .delay(200)
		   .queue(function(next) { jQuery(this).attr('class','close'); next(); })
		   .delay(0)
		   .fadeIn(200); 
		   document.cookie="pmcnotification=open;path=/";
			jQuery("#logo").animate({"top": "+=26px"}, "medium");
			jQuery(".menu-header").animate({"top": "+=26px"}, "medium");


	
			jQuery("#headerwrap").animate({"height": "+=26px"}, "medium");					
	}
	});
});


jQuery(document).ready(function(){	
	jQuery('.gototop').click(function() {
		jQuery('html, body').animate({scrollTop:0}, 'medium');
	});
});

jQuery(document).ready(function(){	
	jQuery('#searchsubmit').val('');
	var screenWidth = screen.availWidth;
	document.cookie="pmcwidth="+screenWidth+";path=/";
});

jQuery(document).ready(function(){	
	jQuery('#remove h2 a:first-child').attr('class','catlink catlinkhover');
	jQuery('.catlink').click(function() {
		jQuery('#remove h2 a').attr('class','catlink');
		jQuery(this).attr('class','catlink catlinkhover');
	});	
});

jQuery(document).ready(function(){	
	 if ( jQuery.browser.msie ) {
	   jQuery('#style-switcher-button').hide();
		}
	jQuery('#style-switcher').hide();
	jQuery('#style-switcher-button').click(function() {
			jQuery('#style-switcher').show();
			jQuery('#style-switcher-button').hide();
	});	
	
	jQuery('#style-switcher').click(function() {
			jQuery('#style-switcher').hide();
			jQuery('#style-switcher-button').show();
	});	
});


jQuery(function(){
    jQuery("ul#ticker01").liScroll();
});




	

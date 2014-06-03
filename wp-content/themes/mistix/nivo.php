<?php
/*
Template Name: Home with Nivo Slider
*/
?>

<?php get_header(); ?>
<?php 
	wp_register_script('pmc_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js?domready=1', array(
		'jquery'
	), true);  
	wp_enqueue_script('pmc_addthis');


?>

<script type="text/javascript">
jQuery(document).ready(function () {
jQuery('#nslider').nivoSlider({
		effect:'<?php echo $data['effect']; ?>', // Specify sets like: 'fold,fade,sliceDown'
        slices:<?php echo $data['slices']; ?>, // For slice animations
        boxCols: <?php echo $data['boxcols']; ?>, // For box animations
        boxRows: <?php echo $data['boxrows']; ?>, // For box animations
        animSpeed:<?php echo $data['anispeed']; ?>, // Slide transition speed
        pauseTime:<?php echo $data['pausetime']; ?>, // How long each slide will show
        startSlide:0, // Set starting Slide (0 index)
        directionNav:false, // Next & Prev navigation
        directionNavHide:true, // Only show on hover
		controlNav:true, // 1,2,3... navigation
		pauseOnHover:false,
		controlNavThumbs: true,
		controlNavThumbsFromRel: true,
		controlNavThumbsSearch: '',
		controlNavThumbsReplace: '',
		captionOpacity:1 
    });
});	
</script>	
<div id="nslider-wrapper">
	<div class="sliderNivo">
	<div id="nslider" class="nivoSlider">
	
	<?php $slides = $data['demo_slider']; 

		foreach ($slides as $slide) { 
	
          if($slide['url'] != '') :
                   
             if($slide['link'] != '') : ?>
               <a href="<?php echo $slide['link']; ?>"><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $slide['url']; ?>&amp;h=380&amp;w=930" title="<?php echo stripText($slide['description']); ?>" rel="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $slide['url']; ?>&amp;h=65&amp;w=110"/></a>
            <?php else: ?>
                <img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $slide['url']; ?>&amp;h=380&amp;w=930" title="<?php echo stripText($slide['description']); ?>" rel="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $slide['url']; ?>&amp;h=65&amp;w=110"/>
            <?php endif; ?>
                    
        <?php endif; ?>
	<?php } ?>
</div></div>
	
</div>

<?php if(isset($data['infotext_status'])) { ?>
	<div class="infotextwrap">
		<div class="infotext">
			<h2><?php echo  stripText($data['infotext'])?></h2>
		</div>
	</div>
	<?php }?>


	<div class="clear"></div>
<div id="mainwrap" class="homewrap">

<div id="main" class="clearfix">

	<div class="clear"></div>

	<?php if($data['racent_status'] || $data['racent_status_port']) { ?>
	<?php if($data['racent_status'] & $data['racent_status_port']) { ?>	
	<div id="remove">
	    <h2>
		<a class="catlink" href="#filter=*" ><?php echo  stripText($data['translation_all']) ?></a>
		<a class="catlink" href="#filter=.post" ><?php echo  stripText($data['translation_post']) ?></a>
		<a class="catlink" href="#filter=.port" ><?php echo  stripText($data['translation_port']) ?></a>
		</h2>
	</div>
	<?php } ?>
	<?php if($data['racent_status'] & !$data['racent_status_port']) { ?>	
	<div id="remove">
		<h2><a class="catlink" href="#filter=*" ><?php echo  stripText($data['translation_all']) ?></a>
		<?php $categories = get_terms("category");
		foreach ($categories as $category) {
			$entrycategory = str_replace(' ', '-', $category->name);
			echo '<a class="catlink" href="#filter=.'.str_replace('.','',$entrycategory) .'" >'.$category->name.'</a>';
		}
		?>
		</h2>
	</div>
	<?php } ?>	
	<?php if(!$data['racent_status'] & $data['racent_status_port']) { ?>	
	<div id="remove">
		<h2><a class="catlink" href="#filter=*" ><?php echo  stripText($data['translation_all']) ?></a>
		<?php $categories = get_terms("portfoliocategory");
		foreach ($categories as $category) {
			$entrycategory = str_replace(' ', '-', $category->name);
			echo '<a class="catlink" href="#filter=.'.str_replace('.','',$entrycategory) .'" >'.$category->name.'</a>';
		}
		?>
		</h2>
	</div>
	<?php } ?>		
	<div id = "showpost">
		<div class="showpostload"><div class="loading"></div></div>
		<div class = "closehomeshow"></div>
		<div class="showpostpostcontent" id="showpostpostcontent"></div>
	</div>
	<?php if($data['racent_status'] & $data['racent_status_port']) { ?>		
		<?php include('includes/boxes/homeracent.php'); ?>
	<?php } ?>
	<?php if($data['racent_status'] & !$data['racent_status_port']) { ?>		
		<?php include('includes/boxes/homeracentPost.php'); ?>
	<?php } ?>
	<?php if(!$data['racent_status'] & $data['racent_status_port']) { ?>		
		<?php include('includes/boxes/homeracentPort.php'); ?>
	<?php } ?>	
	<?php } ?>		
				
<div class="clear"> </div>

	<?php if($data['box_status']) { ?>
	<div class="homeBox">
		<h2><?php echo stripText($data['translation_featured']) ?></h2>
		<?php include('includes/boxes/homebox.php'); ?>
		
	</div>
	<?php }?>

</div>
</div>
<script>
jQuery(function(){
  
      var $container = jQuery('#homeRecent'),
          // object that will keep track of options
          isotopeOptions = {},
          // defaults, used if not explicitly set in hash
          defaultOptions = {
            filter: '*',
            sortBy: 'original-order',
            sortAscending: true,
            layoutMode: 'masonry'
          };

      // ensure no transforms used in Opera
      if ( jQuery.browser.opera ) {
        defaultOptions.transformsEnabled = false;
      }
      
     
  
      var setupOptions = jQuery.extend( {}, defaultOptions, {
        itemSelector : '.itemhome',
      });
  
      // set up Isotope
      $container.isotope( setupOptions );
  
      var $optionSets = jQuery('#options').find('.option-set'),
          isOptionLinkClicked = false;
  
      // switches selected class on buttons
      function changeSelectedLink( $elem ) {
        // remove selected class on previous item
        $elem.parents('.option-set').find('.selected').removeClass('selected');
        // set selected class on new item
        $elem.addClass('selected');
      }
  
  
      $optionSets.find('a').click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return;
        }
        changeSelectedLink( $this );
            // get href attr, remove leading #
        var href = $this.attr('href').replace( /^#/, '' ),
            // convert href into object
            // i.e. 'filter=.inner-transition' -> { filter: '.inner-transition' }
            option = $.deparam( href, true );
        // apply new option to previous
        jQuery.extend( isotopeOptions, option );
        // set hash, triggers hashchange on window
        jQuery.bbq.pushState( isotopeOptions );
        isOptionLinkClicked = true;
        return false;
      });

      var hashChanged = false;

      jQuery(window).bind( 'hashchange', function( event ){
        // get options object from hash
        var hashOptions = window.location.hash ? jQuery.deparam.fragment( window.location.hash, true ) : {},
            // do not animate first call
            aniEngine = hashChanged ? 'best-available' : 'none',
            // apply defaults where no option was specified
            options = jQuery.extend( {}, defaultOptions, hashOptions, { animationEngine: aniEngine } );
        // apply options from hash
        $container.isotope( options );
        // save options
        isotopeOptions = hashOptions;
    
        // if option link was not clicked
        // then we'll need to update selected links
        if ( !isOptionLinkClicked ) {
          // iterate over options
          var hrefObj, hrefValue, $selectedLink;
          for ( var key in options ) {
            hrefObj = {};
            hrefObj[ key ] = options[ key ];
            // convert object into parameter string
            // i.e. { filter: '.inner-transition' } -> 'filter=.inner-transition'
            hrefValue = jQuery.param( hrefObj );
            // get matching link
            $selectedLink = $optionSets.find('a[href="#' + hrefValue + '"]');
            changeSelectedLink( $selectedLink );
          }
        }
    
        isOptionLinkClicked = false;
        hashChanged = true;
      })
        // trigger hashchange to capture any hash data on init
        .trigger('hashchange');

    });
	
</script>

<?php get_footer(); ?>
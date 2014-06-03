<?php
/*
Template Name: 3 Column Portfolio
*/
?>

<?php get_header(); 

?>


<div id="mainwrap">

	<div id="main" class="clearfix">
	
		
	
	<div id="remove">
	    <h2><a class="catlink" href="#filter=*" >Show All</a>
		<?php $categories = get_terms("portfoliocategory");
		foreach ($categories as $category) {
			$entrycategory = str_replace(' ', '-', $category->name);
			echo '<a class="catlink" href="#filter=.'.$entrycategory .'" >'.$category->name.'</a>';
		}
		?>
		</h2>
	</div>


	<div class="portfolio">		
	
				<div id="portitems3">
					
					<?php 
					
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$showposts = $data['port_number'];  
			
						$args = array(
										'showposts' => $showposts ,
										'post_type' => 'portfolioentry'
									  );
			
						$my_query = new WP_Query($args);
						$wp_query = $my_query;
			
						query_posts("showposts=$showposts&post_type=portfolioentry&paged=$paged");
			
						$limit_text = 100;
						$currentindex = '';
						$counter = 0;
					
						while ( have_posts() ) : the_post();
							$do_not_duplicate = $post->ID; 
							$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
						    $entrycategory = get_the_term_list( $post->ID, 'portfoliocategory', '', '_', '' );
							$catstring = $entrycategory;
							$catstring = strip_tags($catstring);
							$catstring = str_replace('_', ', ', $catstring);
							$categoryname = $catstring;							
							$entrycategory = strip_tags($entrycategory);
							$entrycategory = str_replace(' ', '-', $entrycategory);
							$entrycategory = str_replace('_', ' ', $entrycategory);
							
							$catidlist = explode(" ", $entrycategory);
							for($i = 0; $i < sizeof($catidlist); ++$i){
								$catidlist[$i].=$currentindex;
							}
							$catlist = implode(" ", $catidlist);

							$counter++;
							$category = get_the_term_list( $post->ID, 'portfoliocategory', '', ', ', '' );		
						
					?>
							
							<div class="item <?php echo $catlist ?>" data-category="<?php echo $catlist ?>">
								

								<div class="recentborder"></div>
								<h3><a href="<?php the_permalink(); ?>"><?php $title = the_title('','',FALSE);  echo $title  ?></a></h3>
								<div class="overdefult">
									<a href="<?php the_permalink(); ?>"><div class="overLowerDefault"></div></a>
								</div>
								<div class="image">
									<div class="loading"></div>
									<img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $full_image[0]; ?>&amp;h=190&amp;w=290" alt="<?php the_title(); ?>">
								</div>
								<div class="recentborder"></div><h3><?php echo $category  ?></h3>	
								<div class="bottomborder"></div>	
							</div>
								
							
							
						<?php  
						endwhile; 
						?>
					
		</div>
					
		<?php
		include('includes/wp-pagenavi.php');
		if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		?>
				
	</div>
	
</div>	
</div>
<script>

	    jQuery(function(){
  
      var $container = jQuery('#portitems3'),
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
        itemSelector : '.item',
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
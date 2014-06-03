<?php
/*
Template Name: Full Width Page with Nivo slider
*/
?>

<?php get_header(); ?>
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
        directionNav:true, // Next & Prev navigation
        directionNavHide:true, // Only show on hover
		controlNav:false, // 1,2,3... navigation
		pauseOnHover:false
    });
});	
</script>	
<div id="nslider-wrapper">
	<div class="simple sliderNivo">
	<div id="nslider" class="nivoSlider">
	
	<?php $slides = $data['demo_slider']; 

		foreach ($slides as $slide) { 
	
          if($slide['url'] != '') :
                   
             if($slide['link'] != '') : ?>
               <a href="<?php echo $slide['link']; ?>"><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $slide['url']; ?>&amp;h=380&amp;w=940" title="<?php echo $slide['description']; ?>" /></a>
            <?php else: ?>
                <img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $slide['url']; ?>&amp;h=380&amp;w=940" alt="<?php bloginfo(''); ?>" />
            <?php endif; ?>
                    
        <?php endif; ?>
	<?php } ?>
</div></div>
	
</div>
		
<div id="mainwrap">

	<div id="main" class="clearfix">


	<div class="pad"></div>

					<div class="content fullwidth nivo">
					
					
							<div class="postcontent">
								<h1><?php the_title();?></h1>
								<div class="posttext">
									<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
									
									
									<div class="usercontent"><?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?></div>
									
									<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
									
									<?php endwhile; endif; ?>
								</div>
								<div class="linebreak"></div>
								<div class="socialsingle"><?php socialLinkSingle() ?></div>	
				
							</div>
						<div class="bottomborder"></div>
					</div>
	</div>
</div>
<?php get_footer(); ?>

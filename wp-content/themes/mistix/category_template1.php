<?php get_header(); ?>

<script type="text/javascript">
jQuery(document).ready(function($){
	    $('.slider').anythingSlider({
		height		: '300',
		expand		: true,
		autoPlay	: true,
		resizeContents  : true,
		pauseOnHover    : true,
		buildArrows     : false,
		buildNavigation : false,
		delay		: 4000,
		resumeDelay	: 0,
		animationTime	: <?php echo $data['anispeed'] ?>,
		delayBeforeAnimate:0,
		easing : 'easeInOutQuint',	
	    })

	    
	    $('.slider-wrapper').hover(function() {
		$(".slideforward").stop(true, true).fadeIn();
		$(".slidebackward").stop(true, true).fadeIn();
	    }, function() {
		$(".slideforward").fadeOut();
		$(".slidebackward").fadeOut();
	    });
	    $(".pauseButton").toggle(function(){
		$(this).attr("class", "playButton");
		$('#slider').data('AnythingSlider').startStop(false); // stops the slideshow
	    },function(){
		$(this).attr("class", "pauseButton");
		$('.slider').data('AnythingSlider').startStop(true);  // start the slideshow
	    });
	    $(".slideforward").click(function(){
		$('.slider').data('AnythingSlider').goForward();
	    });
	    $(".slidebackward").click(function(){
		$('.slider').data('AnythingSlider').goBack();
	    });
	});
	
</script>	
   

	
<div id="mainwrap">

	<div id="main" class="clearfix">

		<div class="pad"></div>	
					
			<div class="content">
						
				<?php if (have_posts()) : ?>
				
				<?php while (have_posts()) : the_post();
				if ( has_post_format( 'gallery' , $post->ID)) { ?>
				<div class="slider-category">
				
					<div class="blogpostcategory">
					<?php
						$args = array(
							'post_type' => 'attachment',
							'numberposts' => null,
							'post_status' => null,
							'post_parent' => $post->ID,
							'orderby' => 'menu_order ID',
						);
						$attachments = get_posts($args);
						if ($attachments) {?>
						<div id="slider-category" class="slider-category">
							<ul id="slider" class="slider">
								<?php
									foreach ($attachments as $attachment) {
										//echo apply_filters('the_title', $attachment->post_title);
										$image =  wp_get_attachment_image_src( $attachment->ID, 'full' ); ?>	
											<li>
											<div class="slider-item">
												<img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image[0] ?>&amp;h=280&amp;w=580"" />					
													
											</div>			
											</li>
											<?php } ?>
							</ul>
							
								<div class="prevbutton slidebackward"></div>
								<div class="nextbutton slideforward"></div>
							
						</div>
				  <?php } else { 
				  $image = get_template_directory_uri() .'/images/placeholder-580-gallery.png'; ?>
				  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=280&amp;w=580" alt="<?php the_title(); ?>"></a>
				  <?php }?>
					<div class="entry">
						<div class = "meta">
								
								<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							
						</div>
						<p class="content"><?php echo shortcontent('[', ']', '', $post->post_content ,365);?> ...</p>
						<div class="line"></div>
						<a class="textlink"  title = "<?php echo stripText($data['translation_read_more'])?>" href="<?php the_permalink() ?>"><?php echo stripText($data['translation_read_more'])?></a>
						<div class="socialsingle">						
								<div class = "meta">
								
							
								<p class="written"><?php the_author_posts_link(); ?> </p>
								
								<p class="category"><?php the_category(', ') ?> </p>
								
								<p class="comments"><?php comments_popup_link('No comments yet', '1 comment', '% comments'); ?></p>
							</div>
						</div>
					</div>	
					</div>
					<div class="bottomborder"></div>	
				</div>
				<?php } 
				if ( has_post_format( 'video' , $post->ID)) { ?>
				<div class="slider-category">
				
					<div class="blogpostcategory">
					<div class="loading"></div>
					<?php
					if(strstr($post->post_content,'[video]')){
					add_filter( 'the_content', 'filter_content_video' );
					echo the_content();
					remove_filter( 'the_content', 'filter_content_video' );
					}
					else{ 
						  $image = get_template_directory_uri() .'/images/placeholder-580-video.png'; ?>
						  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=280&amp;w=580" alt="<?php the_title(); ?>"></a>
						
					<?php } ?>
					<div class="entry">
						<div class = "meta">
								
								<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

						</div>
						<div class="line"></div>
						<a class="textlink"  title = "<?php echo stripText($data['translation_read_more'])?>" href="<?php the_permalink() ?>"><?php echo stripText($data['translation_read_more'])?></a>
						<div class="socialsingle">						
								<div class = "meta">
								
							
								<p class="written"><?php the_author_posts_link(); ?> </p>
								
								<p class="category"><?php the_category(', ') ?> </p>
								
								<p class="comments"><?php comments_popup_link('No comments yet', '1 comment', '% comments'); ?></p>
							</div>
						</div>
					</div>	
					</div>
					<div class="bottomborder"></div>
				</div>
				<?php } 
				if ( has_post_format( 'link' , $post->ID)) { ?>
				<div class="link-category">
					<div class="blogpostcategory">
					<?php
					add_filter( 'the_content', 'filter_content_link' );?>
					<span><?php echo the_content(); ?> </span>

					<div class="entry">
						<div class = "meta">
								
								<h2 class="title"><a href=<?php echo filter_link($post->post_content) ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

						</div>
						<div class="line"></div>
						<a class="textlink"  title = "<?php echo stripText($data['translation_read_more'])?>" href="<?php echo filter_link($post->post_content) ?>"><?php echo stripText($data['translation_read_more'])?></a>
						<div class="socialsingle">						
								<div class = "meta">
								
							
								<p class="written"><?php the_author_posts_link(); ?> </p>
								
								<p class="category"><?php the_category(', ') ?> </p>
								

							</div>
						</div>
					</div>
					</div>
					<div class="bottomborder"></div>
				</div>
				
				<?php 
				remove_filter( 'the_content', 'filter_content_link' );
				} 				
				if ( !get_post_format() ) {?>
						
				<div class="blogpostcategory">
																
									
						<div class="blogimage">	
									
							<?php	
								if ( has_post_thumbnail() ){
									$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
									$image = $image[0];
									}
								else
									$image = get_template_directory_uri() .'/images/placeholder-580.png'; 
							?>
							
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=280&amp;w=580" alt="<?php the_title(); ?>"></a>
						</div>
						
						<div class="entry">
						
						<div class = "meta">
								
								<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

						</div>
						<p class="content"><?php echo shortcontent('[', ']', '', $post->post_content ,365);?> ...</p>
						<div class="line"></div>
						<a class="textlink"  title = "<?php echo stripText($data['translation_read_more'])?>" href="<?php the_permalink() ?>"><?php echo stripText($data['translation_read_more'])?></a>
						<div class="socialsingle">						
								<div class = "meta">
								
							
								<p class="written"><?php the_author_posts_link(); ?> </p>
								
								<p class="category"><?php the_category(', ') ?> </p>
								
								<p class="comments"><?php comments_popup_link('No comments yet', '1 comment', '% comments'); ?></p>
							</div>
						</div>
						</div>		
				</div>	
				<div class="bottomborder"></div>	
				<?php } ?>		
					<?php endwhile; ?>
					
						<?php
						
							include('includes/wp-pagenavi.php');
							if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
						?>
						
						<?php else : ?>
						
							<div class="postcontent">
								<h1><?php echo $data['errorpagetitle'] ?></h1>
								<div class="posttext">
									<?php echo $data['errorpage'] ?>
								</div>
							</div>
							
						<?php endif; ?>
					
			</div>
					
					<div class="sidebar">	
		
						<?php dynamic_sidebar( 'sidebar-widget' ); ?>
			
					</div>

	</div>
	
</div>				
							
<?php get_footer(); ?>

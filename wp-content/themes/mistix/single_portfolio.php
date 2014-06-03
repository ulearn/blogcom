<div id="mainwrap">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php  $portfolio = get_post_custom($post->ID); ?>
	<div id="main" class="clearfix">
	<div class="pad"></div>
	<div class="content fullwidth">

		<div class="blogpost postcontent port" >
			<div class="projectdetails">
				<h1><?php echo stripText($data['translation_portttitle']); ?></h1>				
				<div class="linehomewrap"><div class="prelinehome"></div><div class="linehome"></div><div class="afterlinehome"></div></div>
				<div class="datecomment">
					<p>
						<?php if($portfolio['detail_active'][0]) {
							if($portfolio['detail_active'][0]) { ?>
							<span class="link"><a href="http://<?php echo $portfolio['website_url'][0] ?>" title="project url"><?php echo $portfolio['website_url'][0] ?></a></span><br>
						<?php } else { ?>
							<span class="link"><a title="project url"><?php echo $portfolio['website_url'][0] ?></a></span><br>
						<?php }  ?>	
						<?php } ?>
						<?php if($portfolio['author'][0] !='') {?>
							<span class="authorp port"><?php echo $portfolio['author'][0] ?></span><br>
						<?php } ?>
						<?php if($portfolio['date'][0] !='') {?>
							<span class="posted-date port"><?php echo $portfolio['date'][0] ?></span><br>
						<?php } ?>
						<?php if($portfolio['customer'][0] !='') {?>
							<span class="author port"><?php echo $portfolio['customer'][0] ?></span><br>
						<?php } ?>		
						<?php if($portfolio['status'][0] !='') {?>
							<span class="status port"><?php echo $portfolio['status'][0] ?></span>
						<?php } ?>	
						<?php
						    $entrycategory = get_the_term_list( $post->ID, 'portfoliocategory', '', '_', '' );
							$catstring = $entrycategory;
							$catstring = strip_tags($catstring);
							$catstring = str_replace('_', ', ', $catstring);
						?>

						<?php if(has_tag()) { ?>
							
							<div class="tags"><span><?php the_tags('',', ',''); ?></span></div>
								
						<?php } ?>						
					</p>
				</div>		
				<div class="linehomewrap"><div class="prelinehome"></div><div class="linehome"></div><div class="afterlinehome"></div></div>				
				<div class="socialsingle"><?php socialLinkSingle() ?></div>	
				<div class="linehomewrap"><div class="prelinehome"></div><div class="linehome"></div><div class="afterlinehome"></div></div>
				<?php if(has_tag()) { ?>
				<div class="linehomewrap"><div class="prelinehome"></div><div class="linehome"></div><div class="afterlinehome"></div></div>
					<div class="tags"><span><?php the_tags('',', ',''); ?></span></div>	
				<?php } ?>			
			</div>
			<div class="projectdescription">		
			<h1><?php the_title();?></h1>	
				<div class="posttext">
					<?php if ( !has_post_format( 'gallery' , $post->ID)) { ?>
						<div class="blogsingleimage">			
							<?php	
							if ( !get_post_format() ) {
								if ( has_post_thumbnail() ){
									$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
									$image = $image[0];
									}
								else
									$image = '/images/placeholder-580-video.png';
								
							?>
							<a href="<?php echo $image ?>" rel="lightbox[single-gallery]" title="<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=350&amp;w=580" ></a>
							<?php } 
							if ( has_post_format( 'video' , $post->ID)) { ?>
								<?php
								add_filter( 'the_content', 'filter_content_video' ); ?>
								<div> <?php  the_content(); ?> </div>
								<?php remove_filter( 'the_content', 'filter_content_video' );
								?> 							
							<?php } ?>
						</div>						
					<?php } else {?>
						<?php
						$args = array(
							'post_type' => 'attachment',
							'numberposts' => -1,
							'post_status' => null,
							'post_parent' => $post->ID
						);
						$attachments = get_posts($args);
						if ($attachments) {?>
						<div class="gallery-single">
						<?php
							foreach ($attachments as $attachment) {
								//echo apply_filters('the_title', $attachment->post_title);
								$image =  wp_get_attachment_image_src( $attachment->ID, 'full' ); 	
								$alt = get_post_meta( $attachment->ID ,'_wp_attachment_image_alt', true);
								if(count($alt)) $title =  $alt; ?>
									<div class="image-gallery">
										<a href="<?php echo $image[0] ?>" rel="lightbox[single-gallery]" title="<?php echo $attachment->post_title ?>"><div class = "over"></div>
											<img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image[0] ?>&amp;h=70&amp;w=70"" />					
										</a>	
									</div>			
									<?php } ?>
						</div>
						<?php } ?>
					<?php }?>
					<div class="sentry">
						<?php if ( has_post_format( 'video' , $post->ID)) { 
							add_filter( 'the_content', 'filter_content' ); ?>
							<div> <?php  the_content(); ?> </div>
							<?php remove_filter( 'the_content', 'filter_content' );
						}
						if(has_post_format( 'gallery' , $post->ID)){?>
							<div class="gallery-content"><?php the_content(); 	?></div>
						<?php } 
						if( !get_post_format()){?> 
							<div> <?php  the_content(); ?> </div>	
						<?php } ?>
					</div>
				
				</div>
				
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>				
				<div > <?php //previous_post_link(); ?></div>
				<div > <?php //next_post_link(); ?> </div>
				<div class="bottomborder"></div>
			</div>						
	</div>	

	
					
	<?php endwhile; else: ?>
					
		
					
	<?php endif; ?>
	</div>



</div>



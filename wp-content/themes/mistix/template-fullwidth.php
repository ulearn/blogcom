<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

			
<div id="mainwrap">

	<div id="main" class="clearfix">


	<div class="pad"></div>

					<div class="content fullwidth">
					
					
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

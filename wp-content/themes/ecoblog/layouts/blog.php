<?php if (have_posts()) { ?>

	<?php while (have_posts()) : the_post(); ?>

		<div class="post">

			<?php if (comments_open()): ?>
				<div class="comment_ico"><?php comments_popup_link('0', '1', '%', '', ''); ?></div>
			<?php endif; ?>
			
			<h1 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>

			<div class="meta">		
				<p class="category"><?php the_category(', '); ?></p>

				<p class="author">
					<?php ide_option('post_author') ? the_author_posts_link()._e(' on ') : null; ?>
					<?php the_time(get_option('date_format')); ?>
				</p>
				
				<div class="clear"> </div>
				<?php if(has_tag()) { ?><p class="tags"><?php the_tags(); ?></p><?php }; ?>
			</div><!-- .meta //-->

			<div class="text">
				<?php
					if(!ide_option('post_content'))
						the_content(_('continue reading..'));	// show full post
					else
						the_excerpt(_('continue reading..'));	// excerpt
				?>
				<div class="clear"> </div>
			</div><!-- .text //-->
			
			<div class="clear"> </div>
		</div><!-- post //-->

	<?php endwhile; ?>
	
		<div class="pagination">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			<div class="clear"> </div>
		</div>

<?php } else {
		_e( !empty($ide_args['empty_message']) ? $ide_args['empty_message'] : '<h1>Sorry!</h1>Sorry, the requested content was not found.');
	}
?>
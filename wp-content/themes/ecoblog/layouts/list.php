<?php if (have_posts()) { ?>

	<?php while (have_posts()) : the_post(); ?>

		<div class="post">
			<h1 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
			<div class="text"><?php the_excerpt('(continue reading...)'); ?></div>
			
			<div class="clear"> </div>
		</div><!-- post //-->

	<?php endwhile; ?>
	
		<div class="pagination">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			<div class="clear"> </div>
		</div>

<?php } else {
		_e( !empty($empty_message) ? $empty_message : '<h1>Sorry!</h1>Sorry, the requested content was not found.');
	}
?>
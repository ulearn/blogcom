<?php get_header(); ?>

<div id="content" class="blog">
	<?php if (have_posts()) : ?>

	<h2 class="pagetitle"><?php _e('Search results for'); ?> &quot;<?php the_search_query(); ?>&quot;</h2>

	<?php endif; ?>
	
	<?php
		$empty_message = '<h1>No results found</h1>No posts were found matching your query.';
		include IDE_PATH.'layouts/list.php';
	?>
</div><!-- content //-->

<?php ide_sidebar(); ?>

<?php get_footer(); ?>
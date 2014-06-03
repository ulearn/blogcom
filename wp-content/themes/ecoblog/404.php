<?php get_header(); ?>

<div id="content">
	<h1><?php _e('Error 404 - Page not found'); ?></h1>
	<?php _e('Sorry, the page you requested was not found.'); ?>
	
	<p>
		<h3><?php _e('Sitemap'); ?></h3>
		<ul><?php wp_list_pages(); ?></ul>
	</p>
</div><!-- content //-->

<?php ide_sidebar(); ?>

<?php get_footer(); ?>
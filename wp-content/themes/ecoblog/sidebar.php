<ul id="sidebar" class="noul">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('right_sidebar') ) : ?>

	<h1><?php _e('Sidebar'); ?></h1>
	<?php _e('Populate your sidebar with widgets'); ?>
	
	<?php endif; ?>
</ul><!-- sidebar //-->
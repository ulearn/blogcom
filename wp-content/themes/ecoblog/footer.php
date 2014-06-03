
		<div class="clear"> </div>
	</div><!-- main //-->
</div><!-- wrap //-->

<div id="footer">
	<div class="content">
		<ul id="footerbar" class="noul">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_sidebar') ) : ?>
			<?php endif; ?>
		</ul><!-- footerbar //-->
		<div class="clear"> </div>
	</div><!-- content //-->
	
	<?php wp_footer(); ?>

	<div class="copyright">
		<div class="content">
			<p class="text"><?php _e('Copyright '.date('Y').' &mdash; '); bloginfo('name'); ?></p>
			<?php
				if(function_exists('wp_nav_menu'))
					wp_nav_menu( array( 'fallback_cb' => '', 'container' => '', 'menu_class' => 'noul footer_nav', 'theme_location' => 'menu_footer' ) );
			?>
			<div id="idesigneco"><a href="http://idesigneco.com/members/go.php?r=<?php echo ide_option('affiliate'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/idesigneco.png" alt="<?php echo get_current_theme(); ?> theme by iDesignEco" title="<?php echo get_current_theme(); ?> theme by iDesignEco" /></a></div>
			<div class="clear"> </div>
		</div>
	</div><!-- copyright //-->
</div><!-- footer //-->

	
</body>
</html>
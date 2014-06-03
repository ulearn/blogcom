<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>












	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

	<meta name="medium" content="blog" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="icon" href="<?php echo ide_option('favicon_url') ? ide_option('favicon_url') : get_bloginfo('template_url').'/favicon.ico'; ?>" type="images/x-icon" />

	
    <?php wp_head(); ?>
</head>

<body <?php body_class( ide_body_class() ); ?>>
<div id="wrap">
	<div id="header">
		<div class="logo">
			<a href="<?php bloginfo('home'); ?>"><img src="<?php echo ide_option('logo_url') ? ide_option('logo_url') : get_bloginfo('template_url').'/images/logo.png';  ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" /></a>
		</div><!-- logo //-->

		<div class="options">
			<form class="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div>
					<input name="s" type="text" class="text" />
					<input type="submit" value="Search" class="button" />
				</div>
			</form>
			<div class="clear"> </div>
			<?php if(ide_option('nav')):
				if(function_exists('wp_nav_menu'))
					wp_nav_menu( array( 'container' => 'div', 'menu_class' => 'nav', 'container_class' => 'nav', 'theme_location' => 'menu_main' ) );
				else
					wp_page_menu('show_home=1&menu_class=nav&title_li=&depth=1&sort_column=menu_order');
			endif; ?>
		</div><!-- options //-->
		<div class="clear"> </div>
	</div><!-- header //-->

	<?php if(ide_option('nav_cat')):
		if(function_exists('wp_nav_menu'))
			wp_nav_menu( array( 'fallback_cb' => 'ide_nav_categories', 'container' => '', 'menu_class' => 'noul nav_categories', 'theme_location' => 'menu_category' ) );
		else
			ide_nav_categories();
	endif; ?>
	
	<div class="clear"> </div>

	<div id="main">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>" type="text/css" media="screen" />

	<!--[if IE 6]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.ie7.css" type="text/css" media="screen" /><![endif]-->

	<?php if(WP_VERSION < 3.0): ?>
		<link rel="alternate" type="application/rss+xml" title="<?php printf(__('%s RSS Feed', THEME_NS), get_bloginfo('name')); ?>" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="alternate" type="application/atom+xml" title="<?php printf(__('%s Atom Feed', THEME_NS), get_bloginfo('name')); ?>" href="<?php bloginfo('atom_url'); ?>" />
	<?php endif; ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php if (is_file(TEMPLATEPATH .'/favicon.ico')):?>
		<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
	<?php endif; ?>

	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/reskin/style.css" type="text/css" media="screen" />

	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/script.js"></script>
</head>
<body <?php if(function_exists('body_class')) body_class(); ?>>
	<div id="wrapper">
		<div id="header">
			<div class="shell" style="position: relative;">
				<h1 id="logo"><a href="<?php bloginfo('home'); ?>">ULEARN : English school dublin</a></h1>
				<div class="cl">&nbsp;</div>
				<div id="navigation">
					<?php wp_nav_menu('theme_location=primary-menu&container='); ?>
				</div>
				<div class="cl" style="height: 37px;">&nbsp;</div>
				<a class="btn-call" href="tel:+35318787339" style="position: absolute; right: 0px; bottom: -10px;">Call Us +353 (0)1 8787 339</a>
			</div>
		</div><!-- /header -->
		<?php
		ob_start();
		?>
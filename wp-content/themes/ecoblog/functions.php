<?php

	/*
		Copyright 2010, idesigneco.com
		http://idesigneco.com
	*/


	define('IDE_NAME', 'ecoBlog');
	define('IDE_CODE', 'ecoblog');
	define('IDE_VERSION', '1.3');

	define('IDE_URL', get_bloginfo('template_url').'/');
	define('IDE_PATH', dirname(__FILE__).'/');
	define('IDE_ADMIN_PATH', IDE_PATH.'admin/');
	define('IDE_ADMIN_STATIC', get_bloginfo('template_url').'/admin/static/');
	
	// theme widgets to load
	$IDE_widgets = array(
		'IDE_widget_ecosocial',
		'IDE_widget_ecobanner'
	);

	// theme javascript files to load
	$IDE_js = array(
		'jquery' => '',
		'eco' => IDE_URL.'eco.js'
	);


	// ________________________________________________________
	$IDE_options = null;

	// install a theme
	function ide_setup_theme() {
		if(!ide_option('setup')) {	// first time
			ide_save_options(
				array(
					'setup' => true,
					'nav' => 'on',
					'sidebar_blog' => 'on',
					'post_fullmeta' => 'on',
					'post_img_resize' => 'on',
				)
			);
		}
	}

	// queue javascript files for loading
	function ide_load_js() {
		global $IDE_js;
		
		foreach($IDE_js as $name=>$src) {
			wp_enqueue_script($name, $src);
		}
	}

	// load widgets
	function ide_load_widgets() {
		global $IDE_widgets;

		foreach($IDE_widgets as $widget) {
			include IDE_PATH.'widgets/'.$widget.'.php';
			register_widget($widget );
		}	
	}

	// classname for page/blog based on the sidebar visibility settings (used for styling)
	function ide_body_class($classes = array()) {

		// page
		if(is_page()) {
			if(!ide_option('sidebar_page'))
				$classes[] = 'nosidebar';
		// blog
		} else {
			$classes[] = 'blog';
			if(!ide_option('sidebar_blog'))
				$classes[] = 'nosidebar';
		}
		
		// site layout
		$classes[] = ide_option('site_layout');
		
		if(get_option('show_on_front') == 'page' && get_option('page_on_front') && is_front_page())
			$classes[] = 'frontpage';

		return implode(' ', $classes);
	}

	// show the sidebar, based on the visibility settings
	function ide_sidebar() {
		$show_sidebar = false;
		if(is_page()) {
			if(ide_option('sidebar_page'))
				$show_sidebar = true;
		} elseif(ide_option('sidebar_blog')) {
			$show_sidebar = true;
		}
		
		if($show_sidebar)
			get_sidebar();
	}
	
	// add content to the template footer, through wp's 'footer' filter
	function ide_footer() {
		echo '
			<script type="text/javascript">
			<!--
				var ide_img_resize = '.(ide_option('post_img_resize') ? 'true' : 'false').'
			//-->
			</script>
		';
		
		echo ide_option('analytics');
	}
	
	// save multiple theme options
	function ide_save_options($data) {
		global $IDE_options;

		$IDE_options = array_merge($IDE_options, $data);
		update_option(IDE_CODE, serialize($IDE_options));
	}
	
	// save a single theme option
	function ide_save_option($key, $value) {
		global $IDE_options;

		$IDE_options[$key] = $value;
		ide_save_options($IDE_options);
	}
	
	// load theme options
	function ide_load_options() {
		global $IDE_options;

		$IDE_options = @unserialize(get_option(IDE_CODE));
		if(!$IDE_options) $IDE_options = array();
	}
	
	// get a particular theme option
	function ide_option($key = null) {
		global $IDE_options;
		return isset($IDE_options[$key]) ? $IDE_options[$key] : null;
	}
	
	// user styles
	function ide_userstyles() {
		if(ide_option('css_enable'))
			wp_enqueue_style('ide_admincss', IDE_URL.'userstyle.php');	// load the admin css
	}
	
	// category navigation
	function ide_nav_categories() {
		?><ul class="noul nav_categories"><?php wp_list_categories('title_li=&depth=1&menu_class=nav_categories'); ?></ul><?php
	}
	
	// ________________________________________________________
	
	// add the theme settings link to WordPress admin menu
	function ide_admin_init() {
	
		wp_enqueue_script('ide_adminjs', IDE_ADMIN_STATIC.'admin.js');	// load the tabber script for admin
		wp_enqueue_style('ide_admincss', IDE_ADMIN_STATIC.'admin.css');	// load the admin css
	
		// add the settings link to admin menu
		add_menu_page(IDE_NAME." Settings", IDE_NAME." Settings", 'edit_themes', basename(__FILE__), 'ide_admin',
			IDE_ADMIN_STATIC.'/ico_admin.png'
		);
	}
	add_action('admin_menu', 'ide_admin_init');

	// load the theme's settings page
	function ide_admin() {
		global $IDE_options;
		include IDE_ADMIN_PATH.'IDE_admin.php';
	}

	// ________________________________________________________	
	
	
	// register dynamic sidebars
	if(function_exists('register_sidebar')) {
	
		register_sidebar(array(
			'name'=>'Right sidebar',
			'id'=>'right_sidebar',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget' => '</li>',
		));
		
		register_sidebar(array(
			'name'=>'Footer bar',
			'id'=> 'footer_sidebar',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget' => '</li>',
		));
	}
	
	// register menus
	if(function_exists('register_nav_menus')) {
		register_nav_menus( array(
			'menu_main' => __('Header navigation'),
			'menu_category' => __('Category navigation'),
			'menu_footer' => __('Footer navigation'),
		));
	}

	
	
	// register api hooks
	add_action('init', 'ide_load_options');
	add_action('admin_init', 'ide_setup_theme');
	add_action('widgets_init', 'ide_load_widgets');
	add_action('get_header', 'ide_load_js');
	add_action('wp_print_styles', 'ide_userstyles');
	add_action('wp_footer', 'ide_footer');
	
	automatic_feed_links();
	
?>
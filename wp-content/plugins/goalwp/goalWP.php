<?php
/*
Plugin Name: MailChimp Goal for WordPress
Plugin URI: http://kb.mailchimp.com/article/how-do-i-use-goals-tracking/
Description: Plugin for adding MailChimp's Goal tracking code to your WordPress site.
Author: Nate Ranson
Version: 1.1.1
Author URI: http://www.mailchimp.com
*/

		load_plugin_textdomain('goalWP', false, basename( dirname( __FILE__ ) ) . '/languages' );

		function goalWP_admin() {
			include(plugin_dir_path( __FILE__ ).'/goalWPsettings.php');
		}


		function goalWP_admin_actions() {
			add_options_page("MailChimp Goal", "MailChimp Goal", 1, "MCGoal", "goalWP_admin");
		}

		add_action('admin_menu', 'goalWP_admin_actions');
		$goalWP = get_option('goalWP');
		if(!empty($goalWP['apikey'])){
			function goalWP_addToHead() {
				include(plugin_dir_path( __FILE__ ).'/scripts/goal.php');
			}

			add_action('wp_head','goalWP_addToHead');

		}

?>

<?php

	/*
		Copyright 2010, idesigneco.com
		http://idesigneco.com
	*/

	define('IDE_ADMIN_FEED', 'http://idesigneco.com/wp_pub.php?id=ide_admin_newsfeed.xml&theme='.IDE_CODE.'&ver='.IDE_VERSION);

	// load form generator and validator
	include IDE_ADMIN_PATH.'IDE_FormGenerator.class.php';
	
	// initialize the admin form
	$Form = new IDE_FormGenerator(array(
		'name' => 'admin',
		'method' => 'post',
		'action' => ''
	));
	
	// setup the form fields
	$Form->elements(
		null,
		array(
			'admin_action' => array(
				'type' => 'hidden', 'value' => 'admin',
				'error' => 'Your settings have been updated.'
			)
		)
	);

	// load theme specific options
	include IDE_ADMIN_PATH.'/IDE_admin_options.php';

	$Form->elements(
		null,
		array(
			'submit' => array(
				'type' => 'submit', 'value' => 'Save', 'label' => ''
			),
		)
	);
	
	$Form->printErrors(true);
	
	
	// ________________________________________________________
	
	// process the form data
	if(!empty($_POST['admin_action'])) {

		// unchecked checkbox options don't show up, so fill them with predefined key names
		ide_save_options( array_merge( array_fill_keys($IDE_checkboxes, ''),
									   stripslashes_deep($_POST)
									  )
						);
		$Form->setErrors(array('admin_action'));
	}

	// ________________________________________________________

	// populate the form with saved options
	$Form->data($IDE_options);
	
	// ________________________________________________________
	
	
	// print out the admin area
	ide_admin_header();
	$Form->generate();
	ide_admin_footer();
	
	// ________________________________________________________

	// idesigneco news feed
	function ide_admin_news() {

		$time = ide_option('admin_newsfeed_time');
		$html =  ide_option('admin_newsfeed');


		// feed expired, update
		if(!$html || !$time || ($time+(5*3600)) < time() ) {
			if(function_exists('fetch_feed')){
				$feed = fetch_feed(IDE_ADMIN_FEED);
				
				if($feed) {
					$html = '<ul>';
					foreach ($feed->get_items() as $item){
						$html.="<li><span>".$item->get_date('d M Y')."</span> <a href=\"".$item->get_permalink()."\">".$item->get_title()."</a></li>";
					}
					$html.= '</ul>';
				} else {
					$html = 'Updates unavailable at this time';
				}
			} else {
				// deprecated feed api
				if(function_exists('fetch_rss')){
					include_once(ABSPATH . WPINC . '/rss.php');
					$rss = fetch_rss(IDE_ADMIN_FEED);
					$html = '<ul>';
					foreach ($rss->items as $item){
						$html.="<li><span>".date('d M Y', strtotime($item['pubdate']))."</span> <a href=\"".$item['link']."\">".$item['title']."</a></li>";
					}
					$html.= '</ul>';
				}
			}
			
			ide_save_option('admin_newsfeed_time', time());
			ide_save_option('admin_newsfeed', $html);
		}


		echo $html;
	}
	

	// admin header
	function ide_admin_header() {
		?>
		<div id="ide_admin">
			<div class="left">
			<h1 class="ide_title"><?php echo IDE_NAME.' '.IDE_VERSION; ?></h1>
			<div class="clear"> </div>
		<?php
	}
	
	// admin footer
	function ide_admin_footer() {
		?>
			</div><!-- left //-->
			
			<div class="right">
				<div class="idesigneco">
					<a href="http://idesigneco.com"><img src="<?php echo IDE_ADMIN_STATIC.'/idesigneco.png'; ?>" alt="Theme by iDesignEco" title="Theme by iDesignEco" /></a>
				</div>
				<div class="news">
					<h2>iDesignEco Updates</h2>
					<?php ide_admin_news(); ?>
				</div>
			</div><!-- right //-->
			<div class="clear"> </div>
			
		</div><!-- ide_admin //-->
		<?php
	}

?>
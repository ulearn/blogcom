<?php
	define('WP_USE_THEMES', false);
	include dirname(__FILE__).'/../../../wp-load.php';
	
	// definitions
	$css = array(
		'headercolor' => "#header { background: [val] !important; }",
		'bodycolor' => "body { background: [val] !important; }",
		'sidebarcolor' => "#sidebar { background: [val] !important; }",
		'sidebarwidgetcolor' => "#sidebar .widget, #sidebar .widget ul { background: [val] !important; }",
		'footerbarcolor' => "#footer { background: [val] !important; }",
		'footerwidgetcolor' => "#footer .widget, #footer .widget ul { background: [val] !important; }",
		'textcolor' => "body { color: [val] !important; }",
		'linkcolor' => "a { color: [val] !important; }",
		'append' => '[val]'
	);

	// content type is css
	header("Content-type: text/css");
	
	foreach($css as $key=>$def) {
		if($val = ide_option('css_'.$key))
			echo str_replace('[val]', $val, $def)."\n";
	}
?>
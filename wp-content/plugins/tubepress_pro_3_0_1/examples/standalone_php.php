<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php 
/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.org)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

/**
 * This file demonstrates how to use TubePress Pro in standalone PHP. There are
 * 4 steps. Please see the documentation for full details.
 */

/*
 * STEP 1/4
 * 
 * Set $tubepress_base_url to the web-accessible URL of your TubePress installation. Make sure this
 *  variable is in global scope (i.e. not inside any code block)
 */
$tubepress_base_url = 'http://yoursite.com/tubepress-pro/';

/*
 * STEP 2/4
 * 
 * Include TubePressPro.php. An absolute path on your filesystem is the least error prone.
 */
include '/some/path/to/tubepress_pro_x_y_z/src/main/php/classes/TubePressPro.php';
?>

<html>
	<head>
		<title>TubePress Pro in standalone PHP</title>

		<!-- STEP 3/4
		    
		     Include this statement inside the HEAD of your HTML document. getHtmlForHead() takes a single boolean
		      argument indicating whether or not to automatically include jQuery. If you are including jQuery elsewhere
		      in your project, use false.
		-->
		<?php print TubePressPro::getHtmlForHead(true); ?>

    </head>
    <body>
		<div>

			<!-- STEP 4/4
			
			     Invoke TubePress! See the documentation for all the different HTML that TubePress can generate for you.
			-->
            <?php print TubePressPro::getHtmlForShortcode("resultsPerPage='20' mode='user' playerLocation='fancybox' ajaxPagination='true'"); ?>

		</div>
	</body>
</html>
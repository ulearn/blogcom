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
 * This example shows how to use TubePress Pro in a WordPress environment, but outside of a WordPress
 * post or page (e.g. in a WordPress template file). Most of the content here is copied from
 * the "World's Simplest Index Page": http://codex.wordpress.org/The_Loop_in_Action
 * 
 * In this example, we're adding a TubePress gallery just after the call to "get_header"
 */

/*
 * STEP 1/2
 * 
 * Include TubePressPro.php. An absolute path on your filesystem is the least error prone.
 */
include '/some/path/to/wordpress/wp-content/plugins/tubepress_pro_x_y_z/src/main/php/classes/TubePressPro.php';

get_header();

/*
 * STEP 2/2
 * 
 * Invoke TubePress! See the documentation for all the different HTML that TubePress can generate for you.
 */
print TubePressPro::getHtmlForShortcode("resultsPerPage='20' mode='user' playerLocation='fancybox' ajaxPagination='true'");

if (have_posts()) :
   while (have_posts()) :
      the_post();
      the_content();
   endwhile;
endif;
get_sidebar();
get_footer(); 
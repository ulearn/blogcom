<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
$categories_tmp = array_unshift($of_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
$of_pages_tmp = array_unshift($of_pages, "Select a page:");       

//Testing 
$of_options_select = array("one","two","three","four","five"); 
$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
$of_options_homepage_blocks = array( 
	"disabled" => array (
		"placebo" 		=> "placebo", //REQUIRED!
		"block_one"		=> "Block One",
		"block_two"		=> "Block Two",
		"block_three"	=> "Block Three",
	), 
	"enabled" => array (
		"placebo" => "placebo", //REQUIRED!
		"block_four"	=> "Block Four",
	),
);


//Stylesheets Reader
$alt_stylesheet_path = LAYOUT_PATH;
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//Background Images Reader
$bg_images_path = STYLESHEETPATH. '/images/bg/'; // change this to where you store your bg images
$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
$bg_images = array();

if ( is_dir($bg_images_path) ) {
    if ($bg_images_dir = opendir($bg_images_path) ) { 
        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                $bg_images[] = $bg_images_url . $bg_images_file;
            }
        }    
    }
}

//Background Images Reader
$bg_images_path_header = STYLESHEETPATH. '/images/bg-header/'; // change this to where you store your bg images
$bg_images_url_header  = get_template_directory_uri().'/images/bg-header/'; // change this to where you store your bg images
$bg_images_header  = array();

if ( is_dir($bg_images_path_header ) ) {
    if ($bg_images_dir_header = opendir($bg_images_path_header) ) { 
        while ( ($bg_images_file_header = readdir($bg_images_dir_header)) !== false ) {
            if(stristr($bg_images_file_header, ".png") !== false || stristr($bg_images_file_header, ".jpg") !== false) {
                $bg_images_header[] = $bg_images_url_header . $bg_images_file_header;
            }
        }    
    }
}

/*-----------------------------------------------------------------------------------*/
/* TO DO: Add options/functions that use these */
/*-----------------------------------------------------------------------------------*/

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
$body_att = array("scroll","fixed");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$number_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","25","30","35","40","45","50");
$slider_entries = array("sliceDown", "sliceDownLeft", "sliceUp", "sliceUpLeft", "sliceUpDown", "sliceUpDownLeft", "fold", "fade", "random", "slideInRight", "slideInLeft", "boxRandom", "boxRain", "boxRainReverse", "boxRainGrow", "boxRainGrowReverse");
$google_fonts = array("", "Allan:bold", "Allerta", "Allerta+Stencil", "Amaranth", "Anonymous+Pro", "Arimo", "Arvo", "Bentham", "Buda:light", "Cabin:bold", "Calligraffitti", "Cantarell", "Cardo", "Cherry+Cream+Soda", "Chewy","Coda:800", "Coming+Soon","Copse", "Corben:bold", "Cousine", "Covered+By+Your+Grace", "Crafty+Girls", "Crimson", "Crushed", "Cuprum", "Droid Sans", "Droid Sans Mono", "Droid Serif", "Fontdiner+Swanky", "Geo", "Gruppo", "Homemade+Apple", "IM Fell", "Inconsolata", "Irish+Growler", "Josefin Sans Std Light", "Josefin+Sans", "Josefin+Slab", "Just+Another+Hand", "Just+Me+Again+Down+Here", "Kenia", "Kranky", "Kreon", "Kristi", "Lato", "Lekton", "Lobster", "Luckiest+Guy", "Maven+Pro", "Merriweather", "Michroma", "Molengo", "Mountains+of+Christmas", "Neucha", "Neuton", "Nobile", "OFL Sorts Mill Goudy TT", "OFL Standard TT", "Orbitron", "Pacifico", "Permanent+Marker", "Philosopher", "PT Sans", "PT Sans Narrow", "Puritan", "Raleway:100", "Reenie Beanie", "Rock+Salt", "Schoolbell", "Six+Caps", "Slackey", "Sniglet:800", "Sunshiney", "Syncopate", "Tangerine", "Tinos", "Ubuntu", "UnifrakturCook:bold", "UnifrakturMaguntia", "Unkempt", "Vibur", "Vidaloka", "Vollkorn", "Walter+Turncoat", "Yanone Kaffeesatz");
$google_fonts_display = str_replace('+', ' ', $google_fonts);

// Image Alignment radio box
$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 

// Set the Options Array
global $of_options;
$of_options = array();

$of_options[] = array( "name" => "Home Settings",
					"type" => "heading");

$of_options[] = array( "name" =>  "Blog type",
					"desc" => "Set the blog type.",
					"id" => "blogtype",
					'options' => array('1' => __('Default', 'nhp-opts'), '2' => __('Full width blog', 'nhp-opts')),
					"std" => "1",					
					"type" => "radio");					

$of_options[] = array( "name" => "Display Tagline?",
					"desc" => "Check this if you wish to display Tagline under logo.",
					"id" => "showtagline",
					"std" => 1,
					"type" => "checkbox");	
					
$of_options[] = array( "name" => "Display info text on Home page?",
					"desc" => "Check this if you wish to display info text below the slideshow.",
					"id" => "infotext_status",
					"std" => 1,
					"type" => "checkbox");						
					
$of_options[] = array( "name" => "Display featured items on Home page?",
					"desc" => "Check this if you wish to display the 3 featured items on the front page.",
					"id" => "box_status",
					"std" => 1,
					"type" => "checkbox");	

$of_options[] = array( "name" => "Display recent Posts on the Home page?",
					"desc" => "Check this if you wish to display recent Posts on Home page (under the 3 featured items).",
					"id" => "racent_status",
					"std" => 1,
					"type" => "checkbox");		

$of_options[] = array( "name" => "Display recent Portfolio items on the Home page?",
					"desc" => "Check this if you wish to display recent Posts on Home page (under the 3 featured items).",
					"id" => "racent_status_port",
					"std" => 1,
					"type" => "checkbox");		
					
$of_options[] = array( "name" => "Shorten Portfolio and Post titles on home page?",
					"desc" => "Check this if you wish to shorten Portfolio and Post titles on home page (under the 3 featured items).",
					"id" => "racent_short_title",
					"std" => 1,
					"type" => "checkbox");							

$of_options[] = array( "name" => "Number of recent portfolio and posts on home page",
					"desc" => "Select how many recent items you wish to display in portfolio",
					"id" => "home_recent_number",
					"std" => "8",
					"type" => "select",
					"options" => $number_entries);						
				
$of_options[] = array( "name" => "Home content Setting",
                    "type" => "heading");
					
					
$of_options[] = array( "name" => "Quote text",
					"desc" => "Set the text that appears in quotation between the featured portfolio and recent posts. Use the span tag to color the certain words in theme color. For instance < span >colored word</ span >. Remove the white space when using them in your Theme.",
					"id" => "infotext",
					"std" => "Home page info text.",
					"type" => "textarea"); 

$of_options[] = array( "name" => "Featured Box 1",
                    "type" => "innerheading");						
					
$of_options[] = array( "name" => "Featured Box 1 Title",
					"desc" => "Title for the first featured box.",
					"id" => "box1_title",
					"std" => "Title 1",
					"type" => "text"); 						
					
$of_options[] = array( "name" => "Featured Box 1 Image (leave empty if you don't need image.)",
					"desc" => "Upload an image for your featured box.",
					"id" => "box1_image",
					"std" => "http://mistix.premiumcoding.com/wp-content/uploads/2012/05/shortcodes-icon-featured1.png",
					"type" => "upload");	

$of_options[] = array( "name" => "Featured Box 1 Image link",
					"desc" => "Set the link to which the image points on click.",
					"id" => "box1_link",
					"std" => "http://premiumcoding.com",
					"type" => "text"); 							

$of_options[] = array( "name" => "Featured Box 1 Description",
					"desc" => "Set the description text for you featured box.",
					"id" => "box1_description",
					"std" => "Short Description",
					"type" => "textarea");

$of_options[] = array( "name" => "Featured Box 2",
                    "type" => "innerheading");	
					
$of_options[] = array( "name" => "Featured Box 2 Title",
					"desc" => "Title for the second featured box..",
					"id" => "box2_title",
					"std" => "Title 2",
					"type" => "text"); 						
					
$of_options[] = array( "name" => "Featured Box 2 Image (leave empty if you don't need image.)",
					"desc" => "Upload an image for your featured box.",
					"id" => "box2_image",
					"std" => "http://mistix.premiumcoding.com/wp-content/uploads/2012/05/shortcodes-icon-featured1.png",
					"type" => "upload");	

$of_options[] = array( "name" => "Featured Box 2 Image link",
					"desc" => "Set the link to which the image points on click.",
					"id" => "box2_link",
					"std" => "http://premiumcoding.com",
					"type" => "text"); 							

$of_options[] = array( "name" => "Featured Box 2 Description",
					"desc" => "Set the description text for you featured box.",
					"id" => "box2_description",
					"std" => "Short Description",
					"type" => "textarea");
					
$of_options[] = array( "name" => "Featured Box 3",
                    "type" => "innerheading");					

$of_options[] = array( "name" => "Featured Box 3 Title",
					"desc" => "Title for the third featured box.",
					"id" => "box3_title",
					"std" => "Title 3",
					"type" => "text"); 	
					
$of_options[] = array( "name" => "Featured Box 3 Image (leave empty if you don't need image.)",
					"desc" => "Upload an image for your featured box.",
					"id" => "box3_image",
					"std" => "http://mistix.premiumcoding.com/wp-content/uploads/2012/05/shortcodes-icon-featured1.png",
					"type" => "upload");
					
$of_options[] = array( "name" => "Featured Box 3 Image link",
					"desc" => "Set the link to which the image points on click.",
					"id" => "box3_link",
					"std" => "http://premiumcoding.com",
					"type" => "text"); 							
					
$of_options[] = array( "name" => "Featured Box 3 Description",
					"desc" => "Set the description text for you featured box.",
					"id" => "box3_description",
					"std" => "Short Description",
					"type" => "textarea");

$of_options[] = array( "name" => "Featured Box 4",
                    "type" => "innerheading");					

$of_options[] = array( "name" => "Featured Box 4 Title",
					"desc" => "Title for the fourth featured box.",
					"id" => "box4_title",
					"std" => "Title 4",
					"type" => "text"); 	
					
$of_options[] = array( "name" => "Featured Box 4 Image (leave empty if you don't need image.)",
					"desc" => "Upload an image for your featured box.",
					"id" => "box4_image",
					"std" => "http://mistix.premiumcoding.com/wp-content/uploads/2012/05/shortcodes-icon-featured1.png",
					"type" => "upload");
					
$of_options[] = array( "name" => "Featured Box 4 Image link",
					"desc" => "Set the link to which the image points on click.",
					"id" => "box4_link",
					"std" => "http://premiumcoding.com",
					"type" => "text"); 							
					
$of_options[] = array( "name" => "Featured Box 4 Description",
					"desc" => "Set the description text for you featured box.",
					"id" => "box4_description",
					"std" => "Short Description",
					"type" => "textarea");								
				
					
$of_options[] = array( "name" => "General Settings",
                    "type" => "heading");
							
					
$of_options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
					"id" => "logo",
					"std" => get_template_directory_uri()."/images/mistix-logo.png",
					"type" => "upload");
					
$of_options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => "favicon",
					"std" => "",
					"type" => "upload"); 					
							
 $of_options[] = array( "name" => "Google Analytics",
                    "desc" => "Paste your Google analytics code here.",
                    "id" => "google_analytics",
                    "std" => "",
                    "type" => "textarea");	   		                                               									
    
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading");

$of_options[] = array( "name" =>  "Main Theme Color ",
					"desc" => "Set the main color for your theme.",
					"id" => "mainColor",
					"std" => "#E35E12",
					"type" => "color");		
					
$of_options[] = array( "name" =>  "Box Color ",
					"desc" => "Set the box color for your theme.",
					"id" => "boxColor",
					"std" => "#ffffff",
					"type" => "color");		
	

$of_options[] = array( "name" =>  "Color of font on hover (portfolio title)",
					"desc" => "Set the color for portfolio title.",
					"id" => "portfolioColor",
					"std" => "#1e1e20",
					"type" => "color");						

$of_options[] = array( "name" =>  "Shadow Color ",
					"desc" => "Set the Shadow color for your fonts.",
					"id" => "ShadowColorFont",
					"std" => "#ffffff",
					"type" => "color");			

$of_options[] = array( "name" => "Shadow opacity",
					"desc" => "Set Shadow opacity (between 0 and 1).",
					"id" => "ShadowOpacittyColorFont",
					"std" => "0.3",
					"type" => "text"); 					
					

$of_options[] = array( "name" => "Body background",
                    "type" => "innerheading");
					
$of_options[] = array( "name" =>  "Body Background Color",
					"desc" => "Pick a background color for the theme.",
					"id" => "body_background_color",
					"std" => "#ffffff",
					"type" => "color");

$of_options[] = array( "name" => "Enable Background Image",
					"desc" => "Displays an image not the color selected above",
					"id" => "background_image",
					"std" => 1,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Background Pattern",
					"desc" => "Select a background pattern.",
					"id" => "body_bg",
					"std" => $bg_images_url."bg9.png",
					"type" => "tiles",
					"options" => $bg_images,
					);	
											
					
$of_options[] = array( "name" => "Custom Background",
					"desc" => "Upload a custom background image for your theme. This will override the option above. This is only for the main background pattern.",
					"id" => "body_bg_custom",
					"std" => "",
					"mod" => "min",
					"type" => "media");	
					
$of_options[] = array( "name" => "Background Image Properties",
					"desc" => "You can define additional shorthand properties for the background such as no-repeat here. This is for advanced CSS users only.",
					"id" => "body_bg_properties",
					"std" => "repeat 0 0",
					"type" => "text"); 		


$of_options[] = array( "name" => "Slider options",
                    "type" => "heading");
					
$of_options[] = array( "name" => "Slider Options",
					"desc" => "You can add unlimited number of images and sort them with drag and drop.",
					"id" => "demo_slider",
					"std" => "",
					"type" => "slider");

$of_options[] = array( "name" => "Main Settings",
                    "type" => "innerheading");	

$of_options[] = array( "name" => "Background transparency of text holder",
					"desc" => "Set the background opacity / transparency of the text holder. (from 0 to 1)",
					"id" => "slider_opacity",
					"std" => "0.5",
					"type" => "text");						

$of_options[] = array( "name" => "Transition time (for animation between images)",
					"desc" => "Set Transition time (for animation between images) - usually a value between 500ms and 1000ms.",
					"id" => "anispeed",
					"std" => "800",
					"type" => "text");

$of_options[] = array( "name" => "Time of Appearance",
					"desc" => "Set how long each slide is shown - usually a value between 5000ms and 10000ms.",
					"id" => "pausetime",
					"std" => "6000",
					"type" => "text");		
					

$of_options[] = array( "name" => "Nivo Slider Options",
                    "type" => "innerheading");
										
					
$of_options[] = array( "name" => "Slider text color and font size for Nivo slider",
					"desc" => "Font color and size for Content text",
					"id" => "slider_fontSize_colorNivo",
					"std" => array('size' => '18px','color' => '#1e1e20'),
					"type" => "sizeColor");		
					
$of_options[] = array( "name" => "Background color of text holder for Nivo slider",
					"desc" => "Set the Background color of text holder.",
					"id" => "slider_backColorNivo",
					"std" => "#ffffff",
					"type" => "color");							

$of_options[] = array( "name" => "Border color of text holder for Nivo slider",
					"desc" => "Set border color of text holder.",
					"id" => "slider_borderColorNivo",
					"std" => "#ffffff",
					"type" => "color");		

$of_options[] = array( "name" => "Slider Transition Effect ",
					"desc" => "Set the Slider Transition Effect (The settings below are for the Nivo Slider).",
					"id" => "effect",
					"std" => "random",
					"type" => "select",
					"options" => $slider_entries); 
					
$of_options[] = array( "name" => "Number of slices",
					"desc" => "Set how many slices the transitions should use. This is only valid for slice animations.",
					"id" => "slices",
					"std" => "15",
					"type" => "select",
					"options" => $number_entries); 					

$of_options[] = array( "name" => "Number of Boxes",
					"desc" => "Set how many boxes the transitions should use. This is only valid for box animations.",
					"id" => "boxcols",
					"std" => "8",
					"type" => "select",
					"options" => $number_entries); 

$of_options[] = array( "name" => "Number of rows",
					"desc" => "Set how many rows the transitions should use. This is only valid for box animations.",
					"id" => "boxrows",
					"std" => "4",
					"type" => "select",
					"options" => $number_entries);
					
			


					
$of_options[] = array( "name" => "Typography",
                    "type" => "heading");
					
$of_options[] = array( "name" => "Body Typography Settings",
					"desc" => "Change body typography. Set the font family, size, color and style.",
					"id" => "body_font",
					"std" => array('size' => '13px','color' => '#1e1e20'),
					"type" => "sizeColor");
					
$of_options[] = array( "name" => "Heading Typography Settings",
					"desc" => "Change heading typography. Set the font family and style.",
					"id" => "heading_font",
					"std" => array('face' => 'Droid%20Sans','style' => 'normal'),
					"type" => "typography");	

$of_options[] = array( "name" => "H1 typography",
					"desc" => "Set H1 font size and color.",
					"id" => "heading_font_h1",
					"std" => array('size' => '30px','color' => '#1e1e20'),
					"type" => "sizeColor");

$of_options[] = array( "name" => "H2 typography",
					"desc" => "Set H2 font size and color.",
					"id" => "heading_font_h2",
					"std" => array('size' => '22px','color' => '#1e1e20'),
					"type" => "sizeColor");
					
$of_options[] = array( "name" => "H3 typography",
					"desc" => "Set H3 font size and color.",
					"id" => "heading_font_h3",
					"std" => array('size' => '20px','color' => '#1e1e20'),
					"type" => "sizeColor");					

$of_options[] = array( "name" => "H4typography",
					"desc" => "Set H4 font size and color.",
					"id" => "heading_font_h4",
					"std" => array('size' => '16px','color' => '#1e1e20'),
					"type" => "sizeColor");	

$of_options[] = array( "name" => "H5 typography",
					"desc" => "Set H5 font size and color.",
					"id" => "heading_font_h5",
					"std" => array('size' => '14px','color' => '#1e1e20'),
					"type" => "sizeColor");		

$of_options[] = array( "name" => "H6 typography",
					"desc" => "Set H6 font size and color.",
					"id" => "heading_font_h6",
					"std" => array('size' => '12px','color' => '#1e1e20'),
					"type" => "sizeColor");							

$of_options[] = array( "name" => "Portfolio & Blog Options",
                    "type" => "heading");

$of_options[] = array( "name" => "Portfolio Title",
					"desc" => "Set the Portfolio Title",
					"id" => "port_title",
					"std" => "Portfolio Title",
					"type" => "text");
					
/*$of_options[] = array( "name" => "Portfolio description",
					"desc" => "Set a short description for Portfolio.",
					"id" => "port_desc",
					"std" => "Portfolio description",
					"type" => "text");*/
					
$of_options[] = array( "name" => "Number of items to be displayed",
					"desc" => "Select the number of items that you wish to display on your portfolio page.",
					"id" => "port_number",
					"std" => "12",
					"type" => "select",
					"options" => $number_entries);	

$of_options[] = array( "name" => "Number of items to be displayed on sorting blog per page",
					"desc" => "Select the number of items that you wish to display on sorting blog per page.",
					"id" => "sortingpost_number", 
					"std" => "50",
					"type" => "select",
					"options" => $number_entries);						
																							
$of_options[] = array( "name" => "Social Options",
					"type" => "heading");  
					
$of_options[] = array( "name" => "Show Facebook icon",
					"desc" => "Check if you wish to show Facebook icon",
					"id" => "facebook_show",
					"std" => 1,
					"type" => "checkbox");							
					
$of_options[] = array( "name" => "Facebook link",
					"desc" => "Set the link used for your Facebook icon.",
					"id" => "facebook",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Show Twitter icon",
					"desc" => "Check if you wish to show Twitter icon",
					"id" => "twitter_show",
					"std" => 1,
					"type" => "checkbox");							

$of_options[] = array( "name" => "Twitter link",
					"desc" => "Set the link used for your Twitter icon.",
					"id" => "twitter",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => "Show Digg icon",
					"desc" => "Check if you wish to show Digg icon",
					"id" => "digg_show",
					"std" => 1,
					"type" => "checkbox");							

$of_options[] = array( "name" => "Digg link",
					"desc" => "Set the link used for your Digg icon.",
					"id" => "digg",
					"std" => "",
					"type" => "text");		

$of_options[] = array( "name" => "Show RSS icon",
					"desc" => "Check if you wish to show RSS icon",
					"id" => "youtube_show",
					"std" => 1,
					"type" => "checkbox");							

$of_options[] = array( "name" => "RSS link",
					"desc" => "Set the link used for your RSS icon.",
					"id" => "youtube",
					"std" => "",
					"type" => "text");	

$of_options[] = array( "name" => "Show Email icon",
					"desc" => "Check if you wish to show Email icon",
					"id" => "email_show",
					"std" => 1,
					"type" => "checkbox");							

$of_options[] = array( "name" => " Email link",
					"desc" => "Set the link used for your Email icon.",
					"id" => "email",
					"std" => "",
					"type" => "text");						
				
								

$of_options[] = array( "name" => "Contact Options",
					"type" => "heading");      

$of_options[] = array( "name" => "Contact description under title",
                    "desc" => "Set the text for description that is under the main Title.",
                    "id" => "contactdesc",
                    "std" => "Contact description under title",
                    "type" => "text");						
					
$of_options[] = array( "name" => "Email address",
                    "desc" => "Set the email address to which the emails should be sent.",
                    "id" => "contactemail",
                    "std" => "",
                    "type" => "text");	

$of_options[] = array( "name" => "Error message",
                    "desc" => "Set the message that will appear in case of an error.",
                    "id" => "contacterror",
                    "std" => "",
                    "type" => "text");	 	

$of_options[] = array( "name" => "Success message",
                    "desc" => "Set the message that will appear when email is sucesfully sent.",
                    "id" => "contactsuccess",
                    "std" => "",
                    "type" => "text");	

$of_options[] = array( "name" => "Error page",
					"type" => "heading");      

					
$of_options[] = array( "name" => "404 Error page Title",
                    "desc" => "Set the title of the Error page (404 not found error).",
                    "id" => "errorpagetitle",
                    "std" => "404 Error page",
                    "type" => "text");	
					
$of_options[] = array( "name" => "404 Error page Sub Title",
                    "desc" => "Set the sub title of the Error page (404 not found error).",
                    "id" => "errorpagesubtitle",
                    "std" => "404 Error page sub title",
                    "type" => "text");						

$of_options[] = array( "name" => "404 Error page Title Content Text",
                    "desc" => "Add a description for your 404 page.",
                    "id" => "errorpage",
                    "std" => "404 Error page",
                    "type" => "textarea");	   	
					
	
$of_options[] = array( "name" => "Footer Options",
					"type" => "heading");      

$of_options[] = array( "name" => "Show Social icon in footer",
					"desc" => "Check if you wish to show Social icon in footer",
					"id" => "showsocialfooter",
					"std" => 1,
					"type" => "checkbox");			
					
$of_options[] = array( "name" => "Copyright info",
                    "desc" => "Add your Copyright or some other notice.",
                    "id" => "copyright",
                    "std" => "&copy; 2011 All rights reserved. ",
                    "type" => "textarea");	

					
					

					
$of_options[] = array( "name" => "Translation",
					"type" => "heading");   					

$of_options[] = array( "name" => "Read more icon alt text",
                    "desc" => "Translation for read more alt text.",
                    "id" => "translation_read_more",
                    "std" => "Read more",
                    "type" => "text");	   
				
$of_options[] = array( "name" => "Social icons title in footer",
                    "desc" => "Translation for social icons title in footer.",
                    "id" => "translation_socialtitle",
                    "std" => "SOCIALIZE WITH US",
                    "type" => "text");	 
					
$of_options[] = array( "name" => "RSS icon alt text",
                    "desc" => "Translation for RSS alt text.",
                    "id" => "translation_facebook",
                    "std" => "RSS",
                    "type" => "text");	 	

$of_options[] = array( "name" => "Twitter icon alt text",
                    "desc" => "Translation for twitter alt text.",
                    "id" => "translation_twitter",
                    "std" => "Twitter",
                    "type" => "text");	

$of_options[] = array( "name" => "Digg icon alt text",
                    "desc" => "Translation for digg alt text.",
                    "id" => "translation_digg",
                    "std" => "Digg",
                    "type" => "text");	

$of_options[] = array( "name" => "Youtube icon alt text",
                    "desc" => "Translation for youtube alt text.",
                    "id" => "translation_youtube",
                    "std" => "Youtube",
                    "type" => "text");						

$of_options[] = array( "name" => "Email icon alt text",
                    "desc" => "Translation for email alt text.",
                    "id" => "translation_email",
                    "std" => "Send us Email",
                    "type" => "text");	
					
$of_options[] = array( "name" => "Tag sub title",
                    "desc" => "Translation for Tag sub title text.",
                    "id" => "translation_subtitle_tag",
                    "std" => "You have reached this page by clicking on the Tag",
                    "type" => "text");			

$of_options[] = array( "name" => "Search sub title",
                    "desc" => "Translation for Search sub title text.",
                    "id" => "translation_subtitle_search",
                    "std" => "You have reached this page by Searching",
                    "type" => "text");		

$of_options[] = array( "name" => "Archive sub title",
                    "desc" => "Translation for Archive sub title text.",
                    "id" => "translation_subtitle_archive",
                    "std" => "You are reading our Archive",
                    "type" => "text");			

$of_options[] = array( "name" => "To top Button",
                    "desc" => "Translation for To top Button text.",
                    "id" => "translation_totop",
                    "std" => "To top",
                    "type" => "text");		

$of_options[] = array( "name" => "Our futured products",
                    "desc" => "Translation for Our futured products text.",
                    "id" => "translation_featured",
                    "std" => "Our futured products",
                    "type" => "text");	
					
$of_options[] = array( "name" => "Related post",
                    "desc" => "Translation for Related post text.",
                    "id" => "translation_relatedpost",
                    "std" => "Related post",
                    "type" => "text");						

$of_options[] = array( "name" => "Home page button show all",
                    "desc" => "Translation for Home page button show all.",
                    "id" => "translation_all",
                    "std" => "Show All",
                    "type" => "text");	

$of_options[] = array( "name" => "Home page button show post",
                    "desc" => "Translation for Home page button show post.",
                    "id" => "translation_post",
                    "std" => "Posts",
                    "type" => "text");	

$of_options[] = array( "name" => "Home page button portfolio",
                    "desc" => "Translation for Home page button portfolio.",
                    "id" => "translation_port",
                    "std" => "Portfolio",
                    "type" => "text");	

$of_options[] = array( "name" => "Read more",
                    "desc" => "Translation for Read more.",
                    "id" => "translation_morelink",
                    "std" => "Read more",
                    "type" => "text");		
					
$of_options[] = array( "name" => "Home page post description title",
                    "desc" => "Translation for Home page post description title.",
                    "id" => "translation_posttitle",
                    "std" => "Post description",
                    "type" => "text");	

$of_options[] = array( "name" => "Home page portfolio description title",
                    "desc" => "Translation for Home page portfolio description title.",
                    "id" => "translation_portttitle",
                    "std" => "Project description",
                    "type" => "text");						


$of_options[] = array( "name" => "Comment translation",
                    "type" => "innerheading");

$of_options[] = array( "name" => "Leave a Reply text",
                    "desc" => "Translation for Leave a Reply title.",
                    "id" => "translation_comment_leave_replay",
                    "std" => "Leave a Reply",
                    "type" => "text");	

$of_options[] = array( "name" => "Leave a Reply to text",
                    "desc" => "Translation for Leave a Reply to title.",
                    "id" => "translation_comment_leave_replay_to",
                    "std" => "Leave a Reply to",
                    "type" => "text");						

$of_options[] = array( "name" => "Name text",
                    "desc" => "Translation for Name text.",
                    "id" => "translation_comment_name",
                    "std" => "Name",
                    "type" => "text");		

$of_options[] = array( "name" => "Mail text",
                    "desc" => "Translation for Mail text.",
                    "id" => "translation_comment_mail",
                    "std" => "Mail",
                    "type" => "text");	

$of_options[] = array( "name" => "Website text",
                    "desc" => "Translation for Website text.",
                    "id" => "translation_comment_website",
                    "std" => "Website",
                    "type" => "text");							

$of_options[] = array( "name" => "Required text",
                    "desc" => "Translation for required text.",
                    "id" => "translation_comment_required",
                    "std" => "required",
                    "type" => "text");							

$of_options[] = array( "name" => "Comments are closed text",
                    "desc" => "Translation for Comments are closed text.",
                    "id" => "translation_comment_closed",
                    "std" => "Comments are closed.",
                    "type" => "text");		

$of_options[] = array( "name" => "No Responses text",
                    "desc" => "Translation for No Responses text.",
                    "id" => "translation_comment_no_responce",
                    "std" => "No Responses",
                    "type" => "text");

$of_options[] = array( "name" => "One Response text",
                    "desc" => "Translation One Response text.",
                    "id" => "translation_comment_one_comment",
                    "std" => "One Response",
                    "type" => "text");

$of_options[] = array( "name" => "Responses text",
                    "desc" => "Translation for Responses text.",
                    "id" => "translation_comment_max_comment",
                    "std" => "Responses",
                    "type" => "text");					
		
$of_options[] = array( "name" => "so far text",
                    "desc" => "Translation for so far text.",
                    "id" => "translation_comment_so_far",
                    "std" => "so far.",
                    "type" => "text");	

$of_options[] = array( "name" => "Submit text",
                    "desc" => "Translation for Submit text.",
                    "id" => "translation_comment_submit",
                    "std" => "Submit",
                    "type" => "text");		

$of_options[] = array( "name" => "Contact translation",
                    "type" => "innerheading");	
					
$of_options[] = array( "name" => "Name text",
                    "desc" => "Translation for Name text.",
                    "id" => "translation_contact_name",
                    "std" => "Name",
                    "type" => "text");	

$of_options[] = array( "name" => "Email text",
                    "desc" => "Translation for Name text.",
                    "id" => "translation_contact_email",
                    "std" => "Name",
                    "type" => "text");	

$of_options[] = array( "name" => "Message text",
                    "desc" => "Translation for Message text.",
                    "id" => "translation_contact_message",
                    "std" => "Message",
                    "type" => "text");						

$of_options[] = array( "name" => "Send text",
                    "desc" => "Translation for Send text.",
                    "id" => "translation_contact_send",
                    "std" => "Send",
                    "type" => "text");	

$of_options[] = array( "name" => "Clear text",
                    "desc" => "Translation for Clear text.",
                    "id" => "translation_contact_cler",
                    "std" => "Clear",
                    "type" => "text");								
				

	}

}
?>

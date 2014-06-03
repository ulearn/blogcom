<?php
//fix for cookie error while login.
setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

add_action('init', 'js_inc_function');
add_theme_support( 'post-formats', array( 'link', 'gallery', 'video' ) );


/*-----------------------------------------------------------------------------------*/
// Options Framework
/*-----------------------------------------------------------------------------------*/

if ( get_magic_quotes_gpc() ) {
    $_POST      = array_map( 'stripslashes_deep', $_POST );
    $_GET       = array_map( 'stripslashes_deep', $_GET );
    $_COOKIE    = array_map( 'stripslashes_deep', $_COOKIE );
    $_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );
}

// Paths to admin functions
define('ADMIN_PATH', STYLESHEETPATH . '/admin/');
define('ADMIN_DIR', get_template_directory_uri() . '/admin/');
define('LAYOUT_PATH', ADMIN_PATH . '/layouts/');

// You can mess with these 2 if you wish.
$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
define('THEMENAME', $themedata['Name']);
define('OPTIONS', 'of_options'); // Name of the database row where your options are stored

// Build Options
require_once (ADMIN_PATH . 'admin-interface.php');		// Admin Interfaces 
require_once (ADMIN_PATH . 'theme-options.php'); 		// Options panel settings and custom settings
require_once (ADMIN_PATH . 'admin-functions.php'); 	// Theme actions based on options settings
require_once (ADMIN_PATH . 'medialibrary-uploader.php'); // Media Library Uploader

$includes = TEMPLATEPATH . '/includes/';
$widget_includes = TEMPLATEPATH . '/includes/widgets/';

require_once ($includes  . 'scripts.php'); // Load JS 

// Other theme options
require_once ($includes . 'menu.php'); 		   // Menus
require_once ($includes . 'formatting.php');
require_once ($includes . 'sidebars.php');
require_once ($includes . 'shortcodes.php');
	
require_once ($widget_includes . 'pop_widget.php'); 
require_once ($widget_includes . 'racent_widget.php'); 
require_once ($widget_includes . 'twitter_widget.php'); 
require_once ($widget_includes . 'contact_widget.php'); 

function fl_shortcode_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "fl_add_shortcode_tinymce_plugin");
		add_filter('mce_buttons', 'fl_register_shortcode_button');
	}
}
 
 if ( ! isset( $content_width ) ) $content_width = 960;
/**
 * Register the TinyMCE Shortcode Button
 */
function fl_register_shortcode_button($buttons) {
	array_push($buttons, "|", "flshortcodes");
	return $buttons;
}

/**
 * Load the TinyMCE plugin: shortcode_plugin.js
 */
function fl_add_shortcode_tinymce_plugin($plugin_array) {
   $plugin_array['flshortcodes'] = get_template_directory_uri() . '/js/shortcode_plugin.js';
   return $plugin_array;
}
 
 function radial_formatter($content) {
    $new_content = '';
    $pattern_full = '{(\[raw\].*?\[/raw\])}is';
    $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
    $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
 
    foreach ($pieces as $piece) {
        if (preg_match($pattern_contents, $piece, $matches)) {
            $new_content .= $matches[1];
        } else {
            $new_content .= wptexturize(wpautop($piece));
        }
    }
 
    return $new_content;
}
 
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
 
add_filter('the_content', 'radial_formatter', 99);

function shortcontent($start, $end, $new, $source, $lenght){
$text = strip_tags(preg_replace('/<h(.*)>(.*)<\/h(.*)>.*/iU', '', $source), '<b><strong>');
$text = preg_replace('#\[video\](.*)\[\/video\]#si', '', $text);
$text = preg_replace('#\[pmc_link\](.*)\[\/pmc_link\]#si', '', $text);
$text = preg_replace('/\[[^\]]*\]/', $new, $text); 
return substr(preg_replace('/\s[\s]+/','',$text),0,$lenght);

}

function fl_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}

function social($url) {
	$social = '';
	global $data; 
	$social .= '<div id="social">';
	if($data['facebook_show'] == 1)
	$social .= '<div class="fb-like" data-href="'.$url.'" data-send="false" data-width="80" data-layout="button_count" data-show-faces="false"></div>';            
	if($data['twitter_show'] == 1)
	$social .= '<div id="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="'.$name.'">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>';
	if($data['google_show'] == 1) 
	$social .= '<div class="g-plusone" data-size="medium"></div>';
	$social .=	'</div>';
	
	echo $social;
}

function footer(){
	function pmc_recent_footer_excerpt_length( $length ) {
		return 40;
	}
	
	function pmc_recent_footer_title($title) { return  substr($title, 0, 40). '';}
		
	add_filter( 'excerpt_length', 'pmc_recent_footer_excerpt_length', 999 );
	add_filter('the_title', 'pmc_recent_footer_title') ;
}

function shortTitle($lenght)
{
	$title = the_title('','',FALSE); 
	echo substr($title, 0, $lenght);
}
function custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function new_excerpt_more($more) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');
function socialLink() {
	$social = '';
	global $data; 
	if($data['facebook_show'] == 1)
	$social .= '<div><a target="_blank" class="facebooklink" href="'.$data['facebook'].'" title="'.$data['translation_facebook'].'"></a></div>';            
	if($data['twitter_show'] == 1)
	$social .= '<div><a target="_blank" class="twitterlink" href="'.$data['twitter'].'" title="'.$data['translation_twitter'].'"></a></div>';  
	if($data['digg_show'] == 1) 
	$social .= '<div><a target="_blank" class="digglink" href="'.$data['digg'].'" title="'.$data['translation_digg'].'"></a></div>';  
	if($data['youtube_show'] == 1)
	$social .= '<div><a target="_blank" class="youtubelink" href="'.$data['youtube'].'" title="'.$data['translation_youtube'].'"></a></div>';  
	if($data['email_show'] == 1) 
	$social .= '<div><a target="_blank" class="emaillink" href="mailto:'.$data['email'].'" title="'.$data['translation_email'].'"></a></div>';  	
	echo $social;
}


function socialLinkCat($link,$title) {
	$social = '';
	$social .='<div class="addthis_toolbox"><div class="custom_images">';
	global $data; 
	if($data['facebook_show'] == 1)
	$social .= '<a class="addthis_button_facebook" addthis:url="'.$link.'" addthis:title="'.$title.'"  title="'.$data['translation_facebook'].'"><img src="'. get_template_directory_uri() .'/images/facebookIcon.png" width="64" height="64" border="0" alt="'.$data['translation_facebook'].'" /></a>';            
	if($data['twitter_show'] == 1)
	$social .= '<a class="addthis_button_twitter" addthis:url="'.$link.'" addthis:title="A'.$title.'"  title="'.$data['translation_twitter'].'"><img src="'. get_template_directory_uri() .'/images/twitterIcon.png" width="64" height="64" border="0" alt="'.$data['translation_twitter'].'" /></a>';  
	if($data['digg_show'] == 1) 
	$social .= '<a class="addthis_button_digg" addthis:url="'.$link.'" addthis:title="'.$title.'" title="'.$data['translation_digg'].'"><img src="'. get_template_directory_uri() .'/images/diggIcon.png" width="64" height="64" border="0" alt="'.$data['translation_digg'].'" /></a>';  
	//if($data['youtube_show'] == 1)
	//$social .= '<div><a class="addthis_button_youtube"><img src="'. get_template_directory_uri() .'/images/diggIcon.png" width="64" height="64" border="0" alt="Share to Twitter" /></div></a></div>';  
	$social .='<a class="addthis_button" addthis:url="'.$link.'" addthis:title="'.$title.'" ><img src="'. get_template_directory_uri() .'/images/socialIconShareMore.png" width="64" height="64" border="0" alt="More..." /></a></div></div><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f3049381724ac5b"></script>';	
	if($data['email_show'] == 1) 
	$social .= '<a class="emaillink" href="mailto:'.$data['email'].'" title="'.$data['translation_email'].'"></a>'; 

	echo $social;
}

function socialLinkSingle() {
	$social = '';
	$social ='<div class="addthis_toolbox"><div class="custom_images">';
	global $data; 
	if($data['facebook_show'] == 1)
	$social .= '<a class="addthis_button_facebook" title="'.$data['translation_facebook'].'"><img src="'. get_template_directory_uri() .'/images/facebookIcon.png" width="64" height="64" border="0" alt="'.$data['translation_facebook'].'" /></a>';            
	if($data['twitter_show'] == 1)
	$social .= '<a class="addthis_button_twitter" title="'.$data['translation_twitter'].'"><img src="'. get_template_directory_uri() .'/images/twitterIcon.png" width="64" height="64" border="0" alt="'.$data['translation_twitter'].'" /></a>';  
	if($data['digg_show'] == 1) 
	$social .= '<a class="addthis_button_digg" title="'.$data['translation_digg'].'"><img src="'. get_template_directory_uri() .'/images/diggIcon.png" width="64" height="64" border="0" alt="'.$data['translation_digg'].'" /></a>';  
	//if($data['youtube_show'] == 1)
	//$social .= '<div><a class="addthis_button_youtube"><img src="'. get_template_directory_uri() .'/images/diggIcon.png" width="64" height="64" border="0" alt="Share to Twitter" /></div></a></div>';  
	$social .='<a class="addthis_button_more"><img src="'. get_template_directory_uri() .'/images/socialIconShareMore.png" width="64" height="64" border="0" alt="More..." /></a></div></div><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f3049381724ac5b"></script>';	
	if($data['email_show'] == 1) 
	$social .= '<a class="emaillink" href="mailto:'.$data['email'].'" title="'.$data['translation_email'].'"></a>'; 
	echo $social;
}

function get_category_id($cat_name){
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}
/**
 * Init process for button control
 */
add_filter( 'tiny_mce_version', 'fl_refresh_mce');
add_action( 'init', 'fl_shortcode_button' );
add_action('init', 'create_portfolio');

function create_portfolio() {
	$portfolio_args = array(
		'label' => 'Portfolio',
		'singular_label' => 'Portfolio',
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt')
	);
	register_post_type('portfolioentry',$portfolio_args);
}
add_action("admin_init", "add_portfolio");
add_action('save_post', 'update_portfolio_data');

function add_portfolio(){
	add_meta_box("portfolio_details", "Portfolio Entry Options", "portfolio_options", "portfolioentry", "normal", "high");
}

function update_portfolio_data(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){
		if( isset($_POST["author"]) ) {
			update_post_meta($post->ID, "author", $_POST["author"]);
		}
		if( isset($_POST["date"]) ) {
			update_post_meta($post->ID, "date", $_POST["date"]);
		}
		if( isset($_POST["detail_active"]) ) {
			update_post_meta($post->ID, "detail_active", $_POST["detail_active"]);
		}else{
			update_post_meta($post->ID, "detail_active", 0);
		}
		if( isset($_POST["website_url"]) ) {
			update_post_meta($post->ID, "website_url", $_POST["website_url"]);
		}
		if( isset($_POST["status"]) ) {
			update_post_meta($post->ID, "status", $_POST["status"]);
		}		
		if( isset($_POST["customer"]) ) {
			update_post_meta($post->ID, "customer", $_POST["customer"]);
		}			

	}
}

function portfolio_options(){
	global $post;
	$data = get_post_custom($post->ID);
	if (isset($data["author"][0])){
		$author = $data["author"][0];
	}else{
		$author = "";
	}
	if (isset($data["date"][0])){
		$date = $data["date"][0];
	}else{
		$date = "";
	}
	if (isset($data["status"][0])){
		$status = $data["status"][0];
	}else{
		$status = "";
	}	
	if (isset($data["detail_active"][0])){
		$detail_active = $data["detail_active"][0];
	}else{
		$detail_active = 0;
		$data["detail_active"][0] = 0;
	}
	if (isset($data["website_url"][0])){
		$website_url = $data["website_url"][0];
	}else{
		$website_url = "";
	}
	
	if (isset($data["customer"][0])){
		$customer = $data["customer"][0];
	}else{
		$customer = "";
	}	

?>

    <div id="portfolio-options">
        <table cellpadding="15" cellspacing="15">
        	<tr>
                <td colspan="2"><strong>Portfolio Overview Options:</strong></td>
            </tr>
            <tr>
                <td><label>Link to Detail Page: <i style="color: #999999;">(Do you want a project detail page?)</i></label></td><td><input type="checkbox" name="detail_active" value="1" <?php if( isset($detail_active)){ checked( '1', $data["detail_active"][0] ); } ?> /></td>	
            </tr>
            <tr>
            	<td><label>Project Link: <i style="color: #999999;">(The URL of your project)</i></label></td><td><input name="website_url" style="width:500px" value="<?php echo $website_url; ?>" /></td>
            </tr>
            <tr>
            	<td><label>Project Author: <i style="color: #999999;">(The URL of your project)</i></label></td><td><input name="author" style="width:500px" value="<?php echo $author; ?>" /></td>
            </tr>
            <tr>
            	<td><label>Project date: <i style="color: #999999;">(Date of project)</i></label></td><td><input name="date" style="width:500px" value="<?php echo $date; ?>" /></td>
            </tr>	
            <tr>
            	<td><label>Customer: <i style="color: #999999;">(Customer of project)</i></label></td><td><input name="customer" style="width:500px" value="<?php echo $customer; ?>" /></td>
            </tr>				
            <tr>
            	<td><label>Project status: <i style="color: #999999;">(Status of project)</i></label></td><td><input name="status" style="width:500px" value="<?php echo $status; ?>" /></td>
            </tr>				
        </table>
    </div>
      
<?php
}

register_taxonomy("portfoliocategory", array("portfolioentry"), array("hierarchical" => true, "label" => "Portfolio Categories", "singular_label" => "Portfolio Category", "rewrite" => true));

add_filter('the_content', 'addlightboxrel_replace');

function addlightboxrel_replace ($content)
{	global $post;
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
  	$replacement = '<a$1href=$2$3.$4$5 rel="lightbox[%LIGHTID%]"$6>';
    $content = preg_replace($pattern, $replacement, $content);
	$content = str_replace("%LIGHTID%", $post->ID, $content);
    return $content;
}


function filter_content_video( $content ){
	$content = explode('[video]', $content );
	$content = explode('[/video]',$content[1] );					
	$content = $content[0];
	return $content;
}

function filter_content( $content ){
	$content = explode('[video]', $content );
	$contentpost = $content[0] . '';
	$content = explode('[/video]',$content[1] );	
	$contentpost .= $content[1]; 
	return $contentpost;
}

function filter_link( $content ){
	$content = explode('[pmc_link]', $content );
	$content = explode('[/pmc_link]',$content[1] );	
	$content = $content[0];
	return $content;
}

function filter_content_link( $content ){
	$content = explode('[pmc_link]', $content );
	$contentcat = $content[0];
	$content = explode('[/pmc_link]',$content[1] );	
	$contentcat .= $content[1];	
	return $contentcat;
}

function stripText($string) 
{ 
    return str_replace("\\",'',$string);
} 

?>
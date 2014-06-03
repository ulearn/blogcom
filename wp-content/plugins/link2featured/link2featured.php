<?php
/*
Plugin Name: Link2Featured Image
Plugin URI: http://www.epicplugins.com/
Description: Add your featured images quickly from an external URL
Version: 1.6
Author: MYO
Author URI: http://www.epicplugins.com/
*/

add_action( 'add_meta_boxes', 'link2featured_custom_meta_box' );
add_action( 'add_meta_boxes', 'url2featured_custom_meta_box' );

function url2featured_custom_meta_box() {
	
	$post_types=get_post_types('','names'); 
	foreach ($post_types as $post_type ) {
	  add_meta_box( 'url2featured', 'external URL to featured image', 'url2featurenew', $post_type , 'side', 'high');
	}
}

function url2featurenew() {
    global $wp, $wpdb, $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="url2feature_noncename" id="url2feature_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Get the location data if its already been entered

   $url = get_post_meta($post->ID,'epic_urlfeatured',true);
   
   echo "<img src = '$url'  style = 'width:240px'/>";
   
	echo "<label>URL for Featured image</label>
	<input type='url' class = 'wide' id = 'epicURL' name='epicURL' value= '$url' size='30'/>"; 
	?>
   <br/><br/>
   <a href = "http://epicplugins.com/external-url-link-to-featured-images/" target = "_blank" style = "float:left">How does this work?</a>
   <input id="publish" class="button-primary button-mini" type="submit" value="Update" accesskey="p" tabindex="5" name="save" style = "float:right">
   
   <div style = "clear:both"></div>	

<?php
}

function wpt_save_url2featurenew() {

     global $wp, $wpdb, $post;  

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if( !isset($_POST['url2feature_noncename'])){
     return $post->ID;
    }
    if (  !wp_verify_nonce( $_POST['url2feature_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
    
    // unhook this function so it doesn't loop infinitely
	remove_action('save_post', 'wpt_save_url2featurenew');

	
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
    return $post->ID;
    // OK, we're authenticated: we need to find and save the data. Make sure we don't add an image every time the post is
    // saved as a draft - so keep track of the external URL in a custom field.
    
	$image		 = 		$_POST['epicURL'];	
	$urlset		 = 		get_post_meta($post->ID,'epic_urlfeatured',true);
	
	if($image != $urlset){

		update_post_meta($post->ID, 'epic_urlfeatured', $image );
		
	}

    add_action('save_post', 'wpt_save_url2featurenew');
   
}
add_action('save_post', 'wpt_save_url2featurenew', 1, 2); // save the custom fields and set the image.


//this could be the magic function to allow featured image from URL
	
add_filter( 'post_thumbnail_html', 'epic_post_image_html', 10, 3 );

function epic_post_image_html( $html, $post_id, $post_image_id ) {
	
$epicurl = get_post_meta($post_id, 'epic_urlfeatured', true);

if($epicurl != ''){

  $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '"><img src = "'. $epicurl. '" /></a>';
  }
  return $html;

}

function link2featured_custom_meta_box() {
	
	$post_types=get_post_types('','names'); 
	foreach ($post_types as $post_type ) {
	  add_meta_box( 'link2featured', 'Upload external image and set as featured', 'link2featurenew', $post_type , 'side', 'high');
	}
}

function link2featurenew() {
    global $wp, $wpdb, $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="link2feature_noncename" id="link2feature_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Get the location data if its already been entered

   $url = get_post_meta($post->ID,'epic_externalURL',true);
	echo "<label>Featured image URL</label>
	<input type='url' class = 'wide' id = 'externalURL' name='externalURL' value= '$url' size='30'/>"; 
	?>
   <br/><br/>
   <a href = "http://epicplugins.com/external-url-link-to-featured-images/" target = "_blank" style = "float:left">How does this work?</a>
   <input id="publish" class="button-primary button-mini" type="submit" value="Upload" accesskey="p" tabindex="5" name="save" style = "float:right">
   
   <div style = "clear:both"></div>	

<?php
}

function wpt_save_link2featurenew() {

     global $wp, $wpdb, $post;  

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if( !isset($_POST['link2feature_noncename'])){
     return $post->ID;
    }
    if (  !wp_verify_nonce( $_POST['link2feature_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
    
    // unhook this function so it doesn't loop infinitely
	remove_action('save_post', 'wpt_save_link2featurenew');

	
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
    return $post->ID;
    // OK, we're authenticated: we need to find and save the data. Make sure we don't add an image every time the post is
    // saved as a draft - so keep track of the external URL in a custom field.
    
	$image		 = 		$_POST['externalURL'];	
	$urlset		 = 		get_post_meta($post->ID,'epic_externalURL',true);
	
	if($image != $urlset){
	
		//extra code to upload the image and set it as the featured image
	$upload_dir = wp_upload_dir();
	$image_data = file_get_contents($image);
	$filename = basename($image);
	if(wp_mkdir_p($upload_dir['path']))
	    $file = $upload_dir['path'] . '/' . $filename;
	else
	    $file = $upload_dir['basedir'] . '/' . $filename;
		file_put_contents($file, $image_data);
		
		$wp_filetype = wp_check_filetype($filename, null );
		$attachment = array(
		    'post_mime_type' => $wp_filetype['type'],
		    'post_title' => sanitize_file_name($filename),
		    'post_content' => '',
		    'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $file, $post->ID );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
	
		set_post_thumbnail($post->ID, $attach_id );	
		update_post_meta($post->ID, 'epic_externalURL', $image );
		
	}

    add_action('save_post', 'wpt_save_link2featurenew');
   
}
add_action('save_post', 'wpt_save_link2featurenew', 1, 2); // save the custom fields and set the image.




add_filter('xmlrpc_methods', 'wpse39662_add_login_method' );
/**
 * Filters the XMLRPC methods to allow just checking the login/pass of
 * a given users
 */
function wpse39662_add_login_method( $methods )
{
    $methods['wpse39662.login'] = 'wpse39662_check_login';
    return $methods;
}

function wpse39662_check_login( $args )
{
    $username = $args[0];
    $password = $args[1];

    $user = wp_authenticate( $username, $password );

    if( is_wp_error( $user ) )
    {
        return false;
    }
    return true;
}



//code for the warnings and auto updating
$api_url = 'http://www.epicplugins.com/api/';
$plugin_slug = basename(dirname(__FILE__));


// Take over the update check
add_filter('pre_set_site_transient_update_plugins', 'l2f_check_for_plugin_update');

function l2f_check_for_plugin_update($checked_data) {
	global $api_url, $plugin_slug;

	//Comment out these two lines during testing.
	if (empty($checked_data->checked))
		return $checked_data;

	$args = array(
		'slug' => $plugin_slug,
		'version' => $checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php'],
	);
	$request_string = array(
			'body' => array(
				'action' => 'basic_check', 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

	// Start checking for an update
	$raw_response = wp_remote_post($api_url, $request_string);

	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);

	if (is_object($response) && !empty($response)) // Feed the update data into WP updater
		$checked_data->response[$plugin_slug .'/'. $plugin_slug .'.php'] = $response;

	return $checked_data;
}



add_filter('plugins_api', 'l2f_plugin_api_call', 10, 3);

function  l2f_plugin_api_call($def, $action, $args) {
	global $plugin_slug, $api_url;

	if ($args->slug != $plugin_slug)
		return false;

	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$plugin_slug .'/'. $plugin_slug .'.php'];
	$args->version = $current_version;

	$request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

	$request = wp_remote_post($api_url, $request_string);

	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>','PicsMash'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);

		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred','PicsMash'), $request['body']);
	}

	return $res;
}






?>
<?php
/*
  Plugin Name: Add Any Lightbox
  Plugin URI: http://www.jamiedust.net/wordpress/
  Description: Add any custom lightbox attribute to linked images or flash files in pages, posts and comments, supports grouping by ID. 
  Author: Jamie Woolgar
  Author URI: http://www.jamiedust.net
  Version: 1.0
  License: GPL2
  Copyright 2011 Jamie Woolgar (email : jamie@jamiedust.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/
//create options page
add_action( 'admin_menu', 'addanylightbox_menu' );
function addanylightbox_menu() {
  add_options_page( 'Add Any Lightbox', 'Add Any Lightbox', 'manage_options', 'addanylightbox-options', 'addanylightbox_settings' );
  add_action( 'admin_init', 'register_addanylightbox_settings' );
}
//register settings
function register_addanylightbox_settings(){
  register_setting( 'addanylightbox_settings_group', 'addanylightbox' );
  register_setting( 'addanylightbox_settings_group', 'addanylightbox_flash' );
}
//setting page
function addanylightbox_settings() {
?>
<div class="wrap">
  <h2>Add Any Lightbox</h2>
  <form method="post" action="options.php">
    <?php
	  settings_fields( 'addanylightbox_settings_group' );
	  do_settings_sections( 'addanylightbox_settings_group' );
	  $addanylightbox_code = htmlspecialchars( get_option( 'addanylightbox' ), ENT_QUOTES );
	  $addanylightbox_flash_code = htmlspecialchars( get_option( 'addanylightbox_flash' ), ENT_QUOTES );
	  $plugin_dir = basename(dirname(__FILE__));
	  load_plugin_textdomain( 'addanylightbox', false, $plugin_dir );
	?>
	<p><?php _e( 'Input lightbox attributes below (both optional), for example <em>rel=&quot;lightbox&quot;</em>, <em>class=&quot;colorbox&quot;</em>.', 'addanylightbox' ) ?></p>
	<p><?php _e( 'To group images by ID use <strong>[id]</strong> for example <em>rel=&quot;prettyPhoto[id]&quot;</em>.', 'addanylightbox' ) ?></p>
	<p><strong style="float:left;display:block;width:45px;text-align:right;margin:3px 6px 0 0;">Images:</strong> <input type="text" style="width:200px;" name="addanylightbox" value="<?php echo $addanylightbox_code; ?>" /></p>
	<p><strong style="float:left;display:block;width:45px;text-align:right;margin:3px 6px 0 0;">Flash:</strong> <input type="text" style="width:200px;" name="addanylightbox_flash" value="<?php echo $addanylightbox_flash_code; ?>" /></p>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>
<?php }
//uninstall hook
if ( function_exists('register_uninstall_hook') )
    register_uninstall_hook(__FILE__, 'addanylightbox_uninstall_hook');
function addanylightbox_uninstall_hook() {
  delete_option('addanylightbox');
  delete_option('addanylightbox_flash');
}
//the replace functions
function addanylightbox_replace( $content ) {
  global $post;
  $addpostid = '[' .$post->ID. ']';
  $addanylightbox_replacement = preg_replace( '/\[(id)\]/', $addpostid, get_option( 'addanylightbox' ) );
  $replacement = '<a$1href=$2$3.$4$5 ' .$addanylightbox_replacement. '$6>$7</a>';
  $content = preg_replace( '/<a(.*?)href=(\'|")([^>]*).(bmp|gif|jpeg|jpg|png)(\'|")(.*?)>(.*?)<\/a>/i', $replacement, $content );
  return $content;
}
function addanylightbox_flash_replace( $content ) {
  global $post;
  $addpostid = '[' .$post->ID. ']';
  $addanylightbox_flash_replacement = preg_replace( '/\[(id)\]/', $addpostid, get_option( 'addanylightbox_flash' ) );
  $replacement = '<a$1href=$2$3.$4$5 '.$addanylightbox_flash_replacement.'$6>$7</a>';
  $content = preg_replace( '/<a(.*?)href=(\'|")([^>]*).(swf|flv)(\'|")(.*?)>(.*?)<\/a>/i', $replacement, $content );
  return $content;
}
//if options set add filters
if ( get_option( 'addanylightbox' ) != null) {
  add_filter( 'the_content', 'addanylightbox_replace', 12 );
  add_filter( 'get_comment_text', 'addanylightbox_replace', 12 );
}
if ( get_option( 'addanylightbox_flash' ) != null) {
  add_filter( 'the_content', 'addanylightbox_flash_replace', 13 );
  add_filter( 'get_comment_text', 'addanylightbox_flash_replace', 13 );
}
?>
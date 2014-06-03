<?php
/*
Plugin Name: Redirect Post
Plugin URI: http://ridhofitra.info/plugin
Description: Easy way to redirect post to another post
Author: Ridho Fitra
Version: 1.4.0
Author URI: http://ridhofitra.info/
*/
function redirect_post_menu() {
	// Add a new menu under Options:
	add_options_page('Redirect Post', 'Redirect Post', 10, __FILE__, 'redirect_plugin_options_page');
}
function redirect_post_embed($contentsss){
		$contentsss .= redirect_post_single($contentsss);
		return $contentsss;
}
function redirect_post_single($contentsss) {
if ( !is_home() and is_single() ){
$current_options2 = get_option('redirect_post_options');
$same_category2 = $current_options2['same_category'];
$type_post2 = $current_options2['type_post'];
$time_redirect = $current_options2['time_redirect'];
//$excluded_categories = '';
$adjacent_post2 = get_adjacent_post($same_category2,'',$type_post2) ;
$link_direct =  get_permalink($adjacent_post2->ID);?><script language="javascript" type="text/javascript">
window.setTimeout('window.location="<?php echo "$link_direct"; ?>"; ',<?php echo "$time_redirect"; ?>*60*1000); 
</script><?
	}
}
function activate_redirect_post(){
		add_filter('the_content', 'redirect_post_embed', 10);
}
activate_redirect_post();
function redirect_plugin_options_page() { 
	$current_options = get_option('redirect_post_options');
	$same_cat = $current_options["same_category"];
	$type_pos = $current_options["type_post"];
	$time_red = $current_options["time_redirect"];
	if ($_POST['action']){ ?>
		<div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>
	<?php } ?>
	<div class="wrap" align="center">
		<h2>Redirect Post Options</h2>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
			<fieldset>
				<input type="hidden" name="action" value="save_redirect_post_options" />
				<table width="500" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<th valign="top" scope="row" align="left"><label for="same_category">Same Category</label></th>
						<td>:</td>
						<td align="left"><select name="same_category">
						<option value ="1"<?php if ($same_cat == "1") { print " selected"; } ?>>Yes</option>
						<option value ="0"<?php if ($same_cat == "0") { print " selected"; } ?>>No</option>
						</select></td>
					</tr>
					<tr align="left">
						<th valign="top" scope="row" align="left"><label for="type_post">Post after redirect</label></th>
						<td>:</td>
						<td ><select name="type_post">
						<option value ="1"<?php if ($type_pos == "1") { print " selected"; } ?>>Previous Post</option>
						<option value ="0"<?php if ($type_pos == "0") { print " selected"; } ?>>Next Post</option>
						</select></td>
					</tr>
					<tr align="left">
						<th valign="top" scope="row" align="left"><label for="time_redirect">Time Redirect </label></th>
						<td>:</td>
						<td><input type="text" name="time_redirect" width="10" maxlength="4" 
						<?php if ($time_red=="" or $time_red=="NULL") echo "value=\"10\"";
						      else echo "value=\"$time_red\"";
					    ?> >(in minutes) default: 10 mnt</td>
					</tr>
				</table>
			</fieldset>
			<p class="submit">
				<input type="submit" name="Submit" value="Update Options &raquo;" />
			</p>
		</form>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	Donation
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ZM2X5DMXRPQML">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>


	<p>Developed by Ridho Fitra &raquo; <a href="http://ridhofitra.info" target="_blank">http://ridhofitra.info</a></p>
	</div>	
<?php 
}
function redirect_post_save_options() {
	// create array
	$redirect_post_options["same_category"] = $_POST["same_category"];
	$redirect_post_options["type_post"] = $_POST["type_post"];
	$redirect_post_options["time_redirect"] = $_POST["time_redirect"];	
	update_option('redirect_post_options', $redirect_post_options);
	$options_saved = true;
}
if (!get_option('redirect_post_options')){
	// create default options
	$redirect_post_options["same_category"] = '0';
	$redirect_post_options["type_post"] = '1';
	$redirect_post_options["time_redirect"] = '10';
	
	update_option('redirect_post_options', $redirect_post_options);
}
if ($_POST['action'] == 'save_redirect_post_options'){
	redirect_post_save_options();
}

function redirect_post_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/redirect-post.php' ) ) {
		$links[] = '<a href="options-general.php?page=redirect-post/redirect-post.php">'.__('Settings').'</a>';
	}
	return $links;
}
add_action('admin_menu', 'redirect_post_menu');
add_filter( 'plugin_action_links', 'redirect_post_action_links', 10, 2 );
?>
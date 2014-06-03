<?php
function goalWPoptions(){
	$goalWP = get_option('goalWP');
	if(empty($goalWP['apikey'])){
		include(plugin_dir_path( __FILE__ ).'/views/goalform.php');
	} else {
		include(plugin_dir_path( __FILE__ ).'/views/goalaccount.php');
	}
};

?>

<div class="wrap" style="max-width:600px;">
<h2>MailChimp Goal Tracking</h2>
<?php

$goalWP = get_option('goalWP');

if($_POST['clear']){
	delete_option('goalWP');
}elseif($_POST['mcapi']){
	include(plugin_dir_path( __FILE__ ).'/lib/Mailchimp.php');
	$goalWPapikey = trim(strip_tags($_POST['mcapi']));
	try{
		$api = new Mailchimp($goalWPapikey);
		$account_details = $api->helper->accountDetails();
		$options['user_id'] = $account_details['user_id'];
		$options['apikey'] = $goalWPapikey;
		$dc = explode("-",$goalWPapikey,2);
		$options['dc'] = $dc[1];
		$options['contact'] = $account_details['contact']['email'];
		$options['username'] = $account_details['username'];
		update_option('goalWP', $options);
		?><div><?php echo __('Success!', 'goalWP');?></div><?php
	}
	catch(Mailchimp_Error $e){
		if($e->getMessage()){
			?><div class="error"><?php echo $e->getMessage();?></div><?
			delete_option('goalWP');
			}
		}
};

goalWPoptions();

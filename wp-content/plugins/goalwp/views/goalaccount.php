<?php
$goalWP = get_option('goalWP');
function goalWPreset(){
	?>
	<div>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="reset" value="Y">
			<input type="submit" value="<?php echo __('Refresh MailChimp Info', 'goalWP');?>">
		</form>
	</div>
	<?
};
function goalWPclear(){
	?>
	<div>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="clear" value="Y">
			<input type="submit" value="<?php echo __('Clear API Key', 'goalWP');?>">
		</form>
	</div>
	<?php
};
?>
<style>
table{
	padding-left:30px;
}
</style>
<div>
	<?php printf(__('You\'re connected to MailChimp and Goal tracking has been added to your site.  Now all you need to do is send a campaign with <a href="%s">Goal tracking</a> enabled.', 'goalWP'), 'http://kb.mailchimp.com/article/how-do-i-use-goals-tracking/#goalcampaign');?>
</div>
<div>
	<h3><?php echo __('Account Info', 'goalWP');?></h3>
		<table>
			<tr>
				<td>
					<strong><?php echo __('MailChimp account:', 'goalWP');?></strong>
				</td>
				<td>
					<?php  _e($goalWP['username']);?>
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php echo __('User ID:', 'goalWP');?></strong>
				</td>
				<td>
					<?php _e($goalWP['user_id']);?>
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php echo __('API Key:', 'goalWP');?></strong>
				</td>
				<td>
					<?php _e($goalWP['apikey']);?>
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php echo __('Datacenter:', 'goalWP');?></strong>
				</td>
				<td>
					<?php _e($goalWP['dc']);?>
				</td>
			</tr>
		</table>
<div class="api_warning" style="padding-top:20px;"><?php printf(__('<strong>Note:</strong>  It\'s important that you keep your API key <a href="%s">private</a>.  Please do not post this key anywhere.', 'goalWP'), 'http://kb.mailchimp.com/article/where-can-i-find-my-api-key#security');?></div>
	<div><h3><?php _e('Helpful links', 'goalWP');?></h3>
		<ul>
			<li><a href="https://blog.mailchimp.com/new-trigger-emails-from-website-traffic/"><?php echo __('Blog post: Trigger emails from website traffic', 'goalWP');?></a></li>
			<li><a href="http://kb.mailchimp.com/article/how-do-i-use-goals-tracking/"><?php echo __('Knowledge Base article: What is Goal and how do I use it?', 'goalWP');?></a></li>
			<li><a href="http://kb.mailchimp.com/article/how-do-i-create-a-new-campaign/"><?php echo __('Knowledge Base article: How do I create a new campaign?', 'goalWP');?></a></li>
			<li><a href="http://kb.mailchimp.com/article/how-can-i-add-additional-tracking-options-to-my-campaigns"><?php echo __('Knowledge Base aritcle: How do I add additional tracking options to my campaigns?', 'goalWP');?></a></li>
		</ul>
	</div>
<?php
goalWPclear();
?>

</div>

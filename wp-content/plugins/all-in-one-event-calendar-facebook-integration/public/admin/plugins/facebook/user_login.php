	<p>
	<?php _e( 'Click below to connect your calendar to Facebook.', AI1EC_PLUGIN_NAME ); ?>
	</p>
	<div id="ai1ec-facebook-connect" class="ai1ec-feed-container">
		<a class="ai1ec-btn ai1ec-btn-primary" href="<?php echo $login_url ?>">
			<i class="ai1ec-fa ai1ec-fa-facebook-square ai1ec-fa-lg ai1ec-fa-fw"></i>
			<?php _e( 'Connect to Facebook', AI1EC_PLUGIN_NAME ) ?>
		</a>
		<?php echo $question_mark ?>
	</div>
	<input type="submit" class="ai1ec-hide" name="<?php echo $submit_name ?>" id="<?php echo $submit_name ?>" value="">
	<?php echo $modal_html ?>



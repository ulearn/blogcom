<?php
/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'contact_widget' );


/* Function that registers our widget. */
function contact_widget() {
	register_widget( 'contact' );
}

class contact extends WP_Widget {
	function contact() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'contact', 'description' => 'Contact widget' );



		/* Create the widget. */
		$this->WP_Widget( 'contact-widget', __('Mistix Contact Widget', 'local'), $widget_ops, '' );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$catname = '';
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$mail = $instance['mail'];
		$tel_mob = $instance['tel_mob'];
		$tel_local = $instance['tel_local'];
		$vcard = $instance['vcard'];	
		$vcardlink = $instance['vcardlink'];	
		$msn = $instance['msn'];		
		echo $before_widget; 
		if ( $title ) echo $before_title . $title . $after_title; 
		?>
	
		<div class="widgett">	
			<?php if ($mail !=''){ ?>
				<div class="contact_mail"><div class = "widgettmailicon"><a href="mailto:<?php echo $mail ?>"><?php echo $mail ?></a></div></div>
			<?php } ?>
			<?php if ($tel_mob !=''){ ?>
				<div class="contact_tel_local"><div class = "widgettmailicon"><?php echo $tel_mob ?></div></div>	
			<?php } ?>			
			<?php if ($tel_local !=''){ ?>			
				<div class="contact_tel_mob"><div class = "widgettmailicon"><?php echo $tel_local ?></div></div>
			<?php } ?>
			<?php if ($vcard !=''){ ?>	
				<div class="contact_vcard"><div class = "widgettmailicon"><a href="<?php echo $vcardlink ?>"><?php echo $vcard ?></a></div></div>
			<?php } ?>			
			<?php if ($msn !=''){ ?>
				<div class="contact_msn"><div class = "widgettmailicon"><?php echo $msn ?></div></div>
			<?php } ?>			
		</div>	

			

		

		
		
	<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['mail'] = $new_instance['mail'];
		$instance['tel_mob'] = $new_instance['tel_mob'];
		$instance['tel_local'] = $new_instance['tel_local'];
		$instance['msn'] = $new_instance['msn'];
		$instance['vcard'] = $new_instance['vcard'];
		$instance['vcardlink'] = $new_instance['vcardlink'];		
		
		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Contact');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'local') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" size="30"  />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'mail' ); ?>"><?php _e('Your email:', 'local') ?></label>
			<input id="<?php echo $this->get_field_id( 'mail' ); ?>" name="<?php echo $this->get_field_name( 'mail' ); ?>" value="<?php echo $instance['mail']; ?>" size="30" />
			<br /><small>(enter your email contact)</small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'tel_mob' ); ?>"><?php _e('Your mobile telephone number:', 'local') ?></label>
			<input id="<?php echo $this->get_field_id( 'tel_mob' ); ?>" name="<?php echo $this->get_field_name( 'tel_mob' ); ?>" value="<?php echo $instance['tel_mob']; ?>" size="30"  />
			<br /><small>(enter your mobile telephone contact)</small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'tel_local' ); ?>"><?php _e('Your local telephone number:', 'local') ?></label>
			<input id="<?php echo $this->get_field_id( 'tel_local' ); ?>" name="<?php echo $this->get_field_name( 'tel_local' ); ?>" value="<?php echo $instance['tel_local']; ?>" size="30"  />
			<br /><small>(enter your local telephone contact)</small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'vcard' ); ?>"><?php _e('Your VCARD contact:', 'local') ?></label>
			<input id="<?php echo $this->get_field_id( 'vcard' ); ?>" name="<?php echo $this->get_field_name( 'vcard' ); ?>" value="<?php echo $instance['vcard']; ?>" size="30"  />
			<br /><small>(enter your VCARD contact)</small>
		</p>	

		<p>
			<label for="<?php echo $this->get_field_id( 'vcardlink' ); ?>"><?php _e('Your VCARD link:', 'local') ?></label>
			<input id="<?php echo $this->get_field_id( 'vcardlink' ); ?>" name="<?php echo $this->get_field_name( 'vcardlink' ); ?>" value="<?php echo $instance['vcardlink']; ?>" size="30"  />
			<br /><small>(enter your VCARD link)</small>
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'msn' ); ?>"><?php _e('Your MSN contact:', 'local') ?></label>
			<input id="<?php echo $this->get_field_id( 'msn' ); ?>" name="<?php echo $this->get_field_name( 'msn' ); ?>" value="<?php echo $instance['msn']; ?>" size="30"  />
			<br /><small>(enter your MSN contact)</small>
		</p>			

		<?php
	}

	function slug($string)
	{
		$slug = trim($string);
		$slug= preg_replace('/[^a-zA-Z0-9 -]/','', $slug); // only take alphanumerical characters, but keep the spaces and dashes too...
		$slug= str_replace(' ','-', $slug); // replace spaces by dashes
		$slug= strtolower($slug); // make it lowercase
		return $slug;
	}

}

?>
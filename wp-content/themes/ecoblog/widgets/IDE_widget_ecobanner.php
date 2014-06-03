<?php

	/*
		Copyright 2010, idesigneco.com
		http://idesigneco.com
	*/


class IDE_widget_ecobanner extends WP_Widget {

	// register the widget
	function IDE_widget_ecobanner() {
		$widget_ops = array(
						'classname' => 'ide_widget_ecobanner',
						'description' => __( 'Easily add banner ads to your sidebar and footerbar')
		);
		$this->WP_Widget('IDE_widget_ecobanner', __('ecoBanner'), $widget_ops);
	}


	// print the widget
	function widget( $args, $instance ) {
		echo $args['before_widget'];
	?>
		<?php if($instance['showtitle']) { ?>
			<h2 class="widgettitle"><?php echo $instance['title']; ?></a></h2>
		<?php } ?>
		
		<a href="<?php echo $instance['link']; ?>"<?php echo $instance['newwindow'] ? ' target="_blank"' : ''; ?>><img src="<?php echo $instance['image']; ?>" alt="title" title="<?php echo $instance['title']; ?>" /></a>
		<div class="clear"> </div>
	<?php
		echo $args['after_widget'];
	}


	// save widget settings
	function update( $new_instance, $old_instance ) {
		return $new_instance;		
	}

	// show widget options form
	function form( $instance ) {
		$title = htmlspecialchars($instance['title']);
		$link = htmlspecialchars($instance['link']);
		$image = htmlspecialchars($instance['image']);
		$newwindow = $instance['newwindow'] ? 'checked="checked"' : '';
		$showtitle = $instance['showtitle'] ? 'checked="checked"' : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link url:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('feedurl'); ?>"><?php _e('Image url:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo esc_attr($image); ?>" /></p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $showtitle; ?> id="<?php echo $this->get_field_id('showtitle'); ?>" name="<?php echo $this->get_field_name('showtitle'); ?>" /> <label for="<?php echo $this->get_field_id('showtitle'); ?>"><?php _e('Display banner title?'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $newwindow; ?> id="<?php echo $this->get_field_id('newwindow'); ?>" name="<?php echo $this->get_field_name('newwindow'); ?>" /> <label for="<?php echo $this->get_field_id('newwindow'); ?>"><?php _e('Open in a new window?'); ?></label>
		</p>
<?php
	}
}
?>
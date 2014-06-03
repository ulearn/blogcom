<?php
/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'pmc_twitter_widget' );



        function getTwitterStatus($username,$tweetnumber){

                $url = "https://api.twitter.com/1/statuses/user_timeline.xml?include_entities=false&include_rts=false&screen_name=$username&count=$tweetnumber&exclude_replies=true";

                $xml = simplexml_load_file("http://api.twitter.com/1/statuses/user_timeline.xml?include_entities=false&include_rts=false&screen_name=$username&count=$tweetnumber&exclude_replies=true");
                $mytweet = '';
                $mytweetURL = '';

                foreach($xml->status as $tweet){
                        //Exclude @ replies
                        $date = $tweet->created_at;
                        $date = date("F j, Y - H:i", strtotime($date));

                        $mytweetURL = 'https://twitter.com/#!/$username/status/'.$tweet->id;
						$text =explode('http',$tweet->text);
						//$link =explode('#',$text[1]);
                        $mytweet .= '<li><div class = "outsideTwitter"><div class = "twitterBird"></div></div><div class = "twitterContent">'.$text[0].'<a href="'.$mytweetURL.'" target="_blank">http'.$text[1].'</a><br>'.$date.'</div></li>';

                }
                return $mytweet;
				

        }
/* Function that registers our widget. */
function pmc_twitter_widget() {
	register_widget( 'pmc_twitters' );
}

class pmc_twitters extends WP_Widget {
	function pmc_twitters() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'pmc_twitters', 'description' => 'Displays latest tweet'.'local' );

		/* Widget control settings. */
		//$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pmc_twitters-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'pmc_twitters-widget', __('Mistix Twitter Widget', 'local'), $widget_ops, '' );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;

		// to sure the number of posts displayed isn't negative or more than 10
		if ( !$number = (int) $instance['number'] )
			$number = 5;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 10 )
			$number = 10;


	
		if ( $title ) echo $before_title . $title . $after_title; 
		
		?>
		<div class="widgett">
			<ul>
				<?php echo getTwitterStatus($instance['username'],$number); ?>	
			</ul>
		</div>
		
		
	<?php
	
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = $new_instance['number'];
		$instance['username'] = $new_instance['username'];
		
		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Twitter', 'number' => 5, 'username' => 'premiumcoding');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'local') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show:', 'local') ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
			<br /><small>(at most 10)</small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter username:', 'local') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>"  />
			<br />
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
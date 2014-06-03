<?php

	$pc = new WP_Query(array('orderby=date', 'showposts' =>  $data['home_recent_number'], 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'post_type' => array( 'portfolioentry'))); 

?>

<div class="homeRacent">
	<div id="homeRecent">
		<?php
		$currentindex = '';
		if ($pc->have_posts()) :
		$count = 1;
		?>
		<?php  while ($pc->have_posts()) : $pc->the_post();		
		$do_not_duplicate = $post->ID; 
		$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
		$entrycategory = get_the_term_list( $post->ID, 'portfoliocategory', '', '_', '' );
		$catstring = $entrycategory;
		$catstring = strip_tags($catstring);
		$catstring = str_replace('_', ', ', $catstring);
		$categoryname = $catstring;							
		$entrycategory = strip_tags($entrycategory);
		$entrycategory = str_replace(' ', '-', $entrycategory);
		$entrycategory = str_replace('_', ' ', $entrycategory);
		
		$catidlist = explode(" ", $entrycategory);
		for($i = 0; $i < sizeof($catidlist); ++$i){
			$catidlist[$i].=$currentindex;
		}
		$catlist = implode(" ", $catidlist);		
		if(get_post_type( $post->ID ) == 'post'){
			$type = 'post';
			$catType= 'category';
		}else{
			$type = 'port';
			$catType= 'portfoliocategory';
		}
		//category
		$category = get_the_term_list( $post->ID, $catType, '', ', ', '' );		
		//end category			
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
			$image = $image[0];}
		else
			$image = get_template_directory_uri() .'/images/placeholder-580.png'; 
			if( has_post_format( 'link' , $post->ID))
			add_filter( 'the_excerpt', 'filter_content_link' );
		if($count != 5){
			echo '<div class="one_fourth itemhome '.str_replace('.','',$catlist) .'" data-category="'. $catlist  .'">';
		}
		else{
			echo '<div class="one_fourth itemhome '.str_replace('.','',$catlist) .'" data-category="'. $catlist  .'">';
			$count = 0;
		}?>
			<?php if ( has_post_format( 'link' , $post->ID)) { ?>
				<div class="recentborder"></div><h3><?php $title = the_title('','',FALSE); if($data['racent_short_title']) echo substr($title, 0, 26); else echo $title  ?></h3>>			
				<a href="<?php echo filter_link($post->post_content) ?>"><div class="overdefult" ><div class="overLowerDefault"></div></div><div class="image"></a><div class="loading"></div><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=140&amp;w=207" alt="<?php the_title(); ?>"></div>		
				<div class="recentborder"></div><h3><?php echo $entrycategory  ?></h3>
				<div class="bottomborder"></div>					
			<?php } elseif ( has_post_format( 'gallery' , $post->ID)) { ?>
				<div class="click" id="<?php echo $type ?>_<?php echo $post->ID ?>">			
				<div class="recentborder"></div><h3><?php $title = the_title('','',FALSE); if($data['racent_short_title']) echo substr($title, 0, 26); else echo $title  ?></h3>			
				<div class="overdefult"><div class="overLowerDefault"></div></div><div class="image"><div class="loading"></div><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=140&amp;w=207" alt="<?php the_title(); ?>"></div></div>	
				<div class="recentborder"></div><h3><?php echo $entrycategory  ?></h3>
				<div class="bottomborder"></div>	
			<?php } elseif ( has_post_format( 'video' , $post->ID)) { ?>
				<div class="click" id="<?php echo $type ?>_<?php echo $post->ID ?>">			
				<div class="recentborder"></div><h3><?php $title = the_title('','',FALSE); if($data['racent_short_title']) echo substr($title, 0, 26); else echo $title  ?></h3>		
				<div class="overdefult"><div class="overLowerDefault"></div></div><div class="image"><div class="loading"></div><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=140&amp;w=207" alt="<?php the_title(); ?>"></div></div>	
				<div class="recentborder"></div><h3><?php echo $entrycategory  ?></h3>
				<div class="bottomborder"></div>
			<?php } elseif ( $type == 'port') { ?>
				<div class="click" id="<?php echo $type ?>_<?php echo $post->ID ?>">			
				<div class="recentborder"></div><h3><?php $title = the_title('','',FALSE); if($data['racent_short_title']) echo substr($title, 0, 26); else echo $title  ?></h3>
				<div class="overdefult"><div class="overLowerDefault"></div></div><div class="image"><div class="loading"></div><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=140&amp;w=207" alt="<?php the_title(); ?>"></div></div>	
				<div class="recentborder"></div><h3><?php echo $entrycategory  ?></h3>
				<div class="bottomborder"></div>				
			<?php } else { ?>
				<div class="click" id="<?php echo $type ?>_<?php echo $post->ID ?>">
				<div class="recentborder"></div><h3><?php $title = the_title('','',FALSE); if($data['racent_short_title']) echo substr($title, 0, 26); else echo $title  ?></h3>
				<div class="overdefult"><div class="overLowerDefault"></div></div><div class="image"><div class="loading"></div><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=140&amp;w=207" alt="<?php the_title(); ?>"></div></div>
				<div class="recentborder"></div><h3><?php echo $entrycategory  ?></h3>
				<div class="bottomborder"></div>				
			<?php } ?>				
			</div>
		<?php 
		$count++;
		endwhile; endif;
		wp_reset_query(); ?>
	</div>
</div>

<div class="clear"></div>


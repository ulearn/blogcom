<?php


//Long posts should require a higher limit, see http://core.trac.wordpress.org/ticket/8553
//@ini_set('pcre.backtrack_limit', 500000);


// Add RSS links to <head> section
if (function_exists('add_theme_support')) {
    add_theme_support('automatic-feed-links');
}

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);


add_filter('widget_text', 'do_shortcode');




function remove_recent_comment_style() {
	global $wp_widget_factory;
	remove_action( 
            'wp_head', 
            array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) 
        );
}
add_action( 'widgets_init', 'remove_recent_comment_style' );

// Ready for theme localisation
load_theme_textdomain('local');



add_theme_support('post-thumbnails');
set_post_thumbnail_size(270, 150);
add_image_size('widget_pop', 75, 75, true);
add_image_size('slider-image', 880, 320, true);
add_image_size('slider', 650, 300, true);
add_image_size('blog', 620, 180, true);
add_image_size('coin', 920, 340, true);

add_filter('post_thumbnail_html', 'my_post_image_html', 10, 3);

function my_post_image_html($html, $post_id, $post_image_id)
{
    $html = '<a href="' . get_permalink($post_id) . '" title="' . esc_attr(get_post_field('post_title', $post_id)) . '">' . $html . '</a>';
    
    return $html;
}


function strip_single_tags($tags, $string)
{
    foreach ($tags as $tag) {
        $string = preg_replace('#</?' . $tag . '[^>]*>#is', '', $string);
    }
    
    //remove empty a and p
    $string = preg_replace('/<a[^>]*><\\/a[^>]*>/', '', $string);
    $string = preg_replace('/<p[^>]*><\\/p[^>]*>/', '', $string);
       
    return $string;
}

function get_the_content_with_formatting($more_link_text = '(more...)', $stripteaser = 0, $more_file = '')
{
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

function better_excerpt($text, $excerpt_length)
{
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
    // replace </p> with <br> and remove <p>
    $text = str_replace("<p>", "", $text);
    $text = str_replace("</p>", "<br/>", $text);
    $text = strip_tags($text, "<br/>");
    $text = str_replace("<br>", "", $text);
    
    
    
    
    $words = explode(' ', $text, $excerpt_length + 1);
    if (count($words) > $excerpt_length) {
        array_pop($words);
        array_push($words, '...');
        $text = implode(' ', $words);
    }
    $text = ltrim($text, "<br>");
    $text = trim($text);
    if ($text == "/>")
        $text = "";
    if (substr($text, 0, 2) == "/>")
        $text = substr($text, 2);
    //return "<p>$text</p>";
    return "$text";
}

function get_all_img_urls($data)
{
    $images = array();
    preg_match_all('/(img|src)\=(\"|\')[^\"\'\>]+/i', $data, $media);
    unset($data);
    $data = preg_replace('/(img|src)(\"|\'|\=\"|\=\')(.*)/i', "$3", $media[0]);
    foreach ($data as $url) {
        $info = pathinfo($url);
        if (isset($info['extension'])) {
            if (($info['extension'] == 'jpg') || ($info['extension'] == 'jpeg') || ($info['extension'] == 'gif') || ($info['extension'] == 'png'))
                array_push($images, $url);
        }
    }
    return $images;
}


// no more jumping for read more link
//function no_more_jumping($post)
//{
//    return '<a href="' . get_permalink($post->ID) . '" class="read-more">' . 'Continue Reading' . '</a>';
//}
//add_filter('excerpt_more', 'no_more_jumping');


	/* Function To Limit Output fl Content.*/
		function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
			$content = get_the_content($more_link_text, $stripteaser, $more_file);
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$content = strip_tags($content);
			
		    if(isset($_GET['p'])){
		   if (strlen($_GET['p']) > 0) {
			  echo $content;
		   }
		   }
		   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
				$content = substr($content, 0, $espacio);
				$content = $content;
				echo $content;
				echo "...";
		   }
		   else {
			  echo $content;
		   }
		}


  
?>
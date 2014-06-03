<?php get_header(); ?>

<?php
  $post = $wp_query->post;
  if (get_post_type( $post->ID ) != 'portfolioentry') {
      include(TEMPLATEPATH.'/single_defult.php');
  } else {
      include(TEMPLATEPATH.'/single_portfolio.php');
	 }
?>

<?php get_footer(); ?>
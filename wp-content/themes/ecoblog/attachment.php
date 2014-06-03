<?php get_header(); ?>

<div id="content">
<?php if (have_posts()) { ?>
	<?php the_post(); ?>

		<div class="post">

			<?php if ( comments_open() && pings_open() ) { ?>
				<div class="comment_ico"><?php comments_popup_link('0', '1', '%', '', ''); ?></div>
			<?php } ?>
			
			<h1 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>

			<div class="meta">		
				<p class="category"><?php the_category(', '); ?></p>

				<p class="author">
					<?php ide_option('post_author') ? the_author_posts_link()._e(' on ') : null; ?>
					<?php the_time(get_option('date_format')); ?>
				</p>
				
				<div class="clear"> </div>
				<?php if(has_tag()) { ?><p class="tags"><?php the_tags(); ?></p><?php }; ?>
			</div><!-- .meta //-->

			<div class="text">
				<?php the_content('(continue reading...)'); ?>
				<div class="clear"> </div>
			</div><!-- .text //-->
			

				<?php if(ide_option('post_fullmeta')): ?>
				<ul class="postmetadata">
						<li>This entry was posted
						on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?>.</li>

						<?php if ( comments_open() && pings_open() ) {
							// Both Comments and Pings are open ?>
							<li>You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.</li>

						<?php } elseif ( !comments_open() && pings_open() ) {
							// Only Pings are Open ?>
							<li>Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.</li>

						<?php } elseif ( comments_open() && !pings_open() ) {
							// Comments are open, Pings are not ?>
							<li>You can skip to the end and leave a response. Pinging is currently not allowed.</li>

						<?php } elseif ( !comments_open() && !pings_open() ) {
							// Neither Comments, nor Pings are open ?>
							<li>Both comments and pings are currently closed.</li>

						<?php } edit_post_link('Edit this entry','','.'); ?>

				</ul>
				<?php endif; ?>
					
			<?php comments_template(); ?>
		</div><!-- post //-->

<?php } else {
		_e('<h1>Sorry!</h1>Sorry, the requested content was not found.');
	}
?>
</div><!-- content //-->

<?php ide_sidebar(); ?>

<?php get_footer(); ?>
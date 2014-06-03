<?php
	global $data;
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div class = "specificComment" id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php printf('<cite class="fn">%s</cite>', get_comment_author_link()) ?><br>
		<div class = "commentsDate"> <?php printf('%1$s at %2$s', get_comment_date(),  get_comment_time()) ?><?php edit_comment_link('(Edit)','  ','') ?></div>
      </div>
	 
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php echo 'Your comment is awaiting moderation.' ?></em>
         <br />
      <?php endif; ?>

	  <div class="avatar"><?php echo get_avatar( $comment->comment_author_email, 70 ); ?></div>
      <div class="commenttext"><?php comment_text() ?></div>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>	 
     </div>

<?php
        }	
?>

<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number(stripText($data['translation_comment_no_responce']), stripText($data['translation_comment_one_comment']), '% '. stripText($data['translation_comment_max_comment']) );?> <?php echo stripText($data['translation_comment_so_far']); ?></h3>


	<ol class="commentlist">
	<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
	</ol>

	<div class="commentnav">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php echo stripText($data['translation_comment_closed']); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<div id="commentform">

<div id="respond">

<h3><?php comment_form_title( stripText($data['translation_comment_leave_replay']), stripText($data['translation_comment_leave_replay_to']).' %s' ); ?></h3>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( is_user_logged_in() ) : ?>

<p>You are logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. Click here to <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out.</a></p>

<?php else : ?>
<div class="commentfield">
<label for="author"><?php echo stripText($data['translation_comment_name']); ?> <small><?php if ($req) echo "(".stripText($data['translation_comment_required']).")"; ?></small></label><br />
<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
</div>
<div class="commentfield">
<label for="email"><?php echo stripText($data['translation_comment_mail']); ?> <small><?php if ($req) echo "(".stripText($data['translation_comment_required']).")"; ?></small></label><br />
<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
</div>
<div class="commentfield">
<label for="url"><?php echo stripText($data['translation_comment_website']); ?> <small><?php echo "(".stripText($data['translation_comment_required']).")"; ?></small></label><br />
<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
</div>

<?php endif; ?>

<textarea name="comment" id="comment" cols="75%" rows="8" tabindex="4"></textarea><br />

<input name="submit" type="submit" id="commentSubmit" tabindex="5" value="<?php echo stripText($data['translation_comment_submit']); ?>" />
<?php comment_id_fields(); ?>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>

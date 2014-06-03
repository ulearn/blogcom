<?php
/*
Template Name: Contact sidebar
*/
?>

<?php get_header(); ?>




<div id="mainwrap">
	<div id="main" class="clearfix">
	
		<div class="pad"></div>
		
		<div class="content contact">
				<div class="postcontent">
					<h1><?php the_title();?></h1>
					<div class="posttext">
			
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>		
						
						
						<?php the_content(); ?>
							
					
						<?php endwhile; endif; ?>
						
						<form method="post" id="contatti" action="<?php echo get_template_directory_uri(); ?>/sendemail.php"> 
							<div id="contactform"> 

								<div class="commentfield">							
								<label for="author"><?php echo stripText($data['translation_contact_name']) ?> <small><?php  echo "(".stripText($data['translation_comment_required']).")"; ?></small></label>							
								<input type="text" name="name" id="name" />						
								</div>
								<div class="commentfield">							
								<label for="email"><?php echo stripText($data['translation_contact_email']) ?> <small><?php  echo "(".stripText($data['translation_comment_required']).")"; ?></small></label>							
								<input type="text" name="email" id="email" /> 													
								</div>
								<div class="commentfield">									
								<label for="message"><?php echo stripText($data['translation_contact_message']) ?> <small><?php  echo "(".stripText($data['translation_comment_required']).")"; ?></small></label>
								<div class="commentfieldarea"><textarea name="message" id="testo" rows="12" cols="" ></textarea>	
								</div>
								</div>
								<input type="hidden" name="errorM" id="errorM" value="<?php echo stripText($data['contacterror']) ?>" />
								<input type="hidden" name="successM" id="successM" value="<?php echo stripText($data['contactsuccess']) ?>" />
								<input type="hidden" name="mailto" id="mailto" value="<?php echo stripText($data['contactemail']) ?>" />
								<div class="contactbutton"> 
									<input type="submit" class="contact-button" name="submit" id="invia" value="<?php echo stripText($data['translation_contact_send']) ?>"/>
									<input type="reset" class="contact-button" name="clear" value="<?php echo stripText($data['translation_contact_cler']) ?>"/>
								</div>
								<span id="result"><?php echo stripText($data['contacterror']) ?></span>
								<span id="resultsuccess"><?php echo stripText($data['contactsuccess']) ?></span>
							</div> 
						</form> 
					</div>
				</div>
				<div class="bottomborder"></div>
			</div>

<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>

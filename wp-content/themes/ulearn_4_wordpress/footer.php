			<?php
			$content = ob_get_clean();
			echo art_parse_template(art_page_template(), art_page_variables(array('content'=> $content)));
			?>
		    <div id="footer">
			<div id="footer-inner">
				<div class="shell">
					<div class="col-1">
						<?php $tweets = ul_get_tweets(); ?>
	                    <h4>Recent Tweets</h4>
	                    <div class="latest-tweets">
	                        <ul>
	                            <?php $i = 0; foreach ($tweets as $t) : ?>
	                                <li class="<?php echo ($i == count($tweets) - 1) ? 'last' : ''; ?>">
	                                    <?php echo $t->title; ?>
	                                    <div class="meta">
	                                        about <?php echo $t->time; ?> ago
	                                    </div>
	                                </li>
	                            <?php $i ++; endforeach; ?>
	                        </ul>
	                    </div>
					</div>
					<div class="col-2">
						<?php query_posts( 'posts_per_page=1' ); ?>
						<?php if(have_posts()): ?>
							<?php while(have_posts()) : the_post(); ?>
								<h4>From The Blog</h4>
								<div class="featured-post">
									<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
									<p>
										<?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>">read more</a>
									</p>
								</div>
							<?php endwhile;  ?>
						<?php endif; ?>
						<?php wp_reset_query(); ?>
					</div>
					<div class="col-3">
						<h4>Find Out More</h4>
						<div class="contacts">
							ULearn, 97 St Stephens Green, <br />
							Dublin 2, Ireland<br /><br />
							<strong>Tel:</strong> +353 (0) 87 87 339<br />
							<strong>Fax:</strong> +353 (0) 87 87 334<br />
							<strong>Email:</strong> info@ulearn.ie
						</div>
						<ul class="social-links">
							<li><a href="http://www.ulearn.ie/blog"><img src="<?php bloginfo('template_directory'); ?>/reskin/images/icon-rss.png" alt="" /></a></li>
	                        <li><a target="_blank" href="http://ulearn.ie/twitter.com/ULearnDublin"><img src="<?php bloginfo('template_directory'); ?>/reskin/images/icon-twitter.png" alt="" /></a></li>
	                        <li><a target="_blank" href="http://www.facebook.com/pages/U-Learn-Dublin-English-School/110245482320090"><img src="<?php bloginfo('template_directory'); ?>/reskin/images/icon-facebook.png" alt="" /></a></li>
	                        <li><a href="skype:U-Learn?call"><img src="<?php bloginfo('template_directory'); ?>/reskin/images/icon-skype2.png" alt="" /></a></li>
	                        <li><a target="_blank" href="http://www.youtube.com/user/ULearnDublin"><img src="<?php bloginfo('template_directory'); ?>/reskin/images/icon-youtube.png" alt="" /></a></li>
	                        <li><a target="_blank" href="http://maps.google.ie/maps/place?rlz=1C1SVEE_enIE419&um=1&ie=UTF-8&q=ulearn+english+school+dublin&fb=1&gl=ie&hq=ulearn+english+school&hnear=Dublin,+Co.+Fingal&cid=7136853069030798392"><img src="<?php bloginfo('template_directory'); ?>/reskin/images/icon-google.png" alt="" /></a></li>
						</ul>
					</div>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
		</div><!-- /footer -->
	</div><!-- /wrapper -->
</body>
</html>


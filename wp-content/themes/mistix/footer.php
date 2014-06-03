<?php
footer();
global $data;
?>



<footer>
		
<div id="footer">
	<div class="totop"><div class="gototop"><div class="arrowgototop"></div></div></div>
	<div class="fshadow"></div>
	
	<div id="footerinside">
	


		<div class="footer_widget">
			
				<div class="footer_widget1">
				<?php dynamic_sidebar( 'footer1' ); ?>
				</div>	
				
				<div class="footer_widget2">	
				<?php dynamic_sidebar( 'footer2' ); ?>
				</div>	
				
				<div class="footer_widget3">	
				<?php dynamic_sidebar( 'footer3' ); ?>
				</div>
				
				<div class="footer_widget4 last">	
				<?php dynamic_sidebar( 'footer4' ); ?>
				</div>
				
		</div>



	</div>
	
	
	
		<div id="footerbwrap">
			<div id="footerb">
				<?php if($data['showsocialfooter']){ ?>
				<div class="socialcategory"><span><?php echo stripslashes($data['translation_socialtitle']); ?></span><?php socialLink() ?></div>
				<?php } ?>
			<div class="copyright">
			<?php 
	
				echo stripslashes($data['copyright']); ?>
			</div>
		</div>
	</div>
</div>
<a title="ULearn English School Dublin" href="https://plus.google.com/u/2/118358502529790750396?rel=author" target="_blank">ULearn English School Dublin</a>
</footer>	
		
<?php wp_footer();  ?>
<script type="text/javascript" charset="utf-8">
 jQuery(document).ready(function(){
    jQuery("a[rel^='lightbox']").prettyPhoto({theme:'light_rounded',overlay_gallery: false,show_title: false});
  });
</script>
</body>
</html>
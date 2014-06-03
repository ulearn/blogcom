<?php
function js_inc_function()
{
    if (!is_admin()) {
    
        //wp_deregister_script('jquery');
        //wp_register_script('pmc_jquery', 'http://code.jquery.com/jquery-1.7.1.min.js', true);
        //wp_enqueue_script('pmc_jquery');
         wp_register_script('pmc_customjs', get_template_directory_uri() . '/js/custom.js', array(
            'jquery'
        ), true);  
		wp_enqueue_script('pmc_customjs');		      
        /*wp_register_script('pmc_modinizer', get_template_directory_uri() . '/js/modernizr-2.0.6.min', array(
            'jquery'
        ), true);
		wp_enqueue_script('pmc_modinizer');*/
		
        wp_register_script('pmc_prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(
            'jquery'
        ), true);
		wp_enqueue_script('pmc_prettyphoto');
		
        wp_register_script('pmc_jtools', get_template_directory_uri() . '/js/jquery.tools.min.js', array(
            'jquery'
        ), true);
		wp_enqueue_script('pmc_jtools');
		
        wp_register_script('pmc_easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array(
            'jquery'
        ), true);
		wp_enqueue_script('pmc_easing');
		
        wp_register_script('pmc_carousel', get_template_directory_uri() . '/js/jcarousellite_1.0.1.min.js', array(
            'jquery'
        ), true);
		wp_enqueue_script('pmc_carousel');
		
        wp_register_script('pmc_cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array(
            'jquery'
        ), true);
		wp_enqueue_script('pmc_cycle');
		
		wp_register_script('pmc_superfish', get_template_directory_uri() . '/js/superfish.js', array(
		'jquery'
		),  true);
		wp_enqueue_script('pmc_superfish');
		
        wp_register_script('pmc_nivo', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', array(
            'jquery'
        ), true);
		wp_enqueue_script('pmc_nivo');
		
        wp_register_script('pmc_any', get_template_directory_uri() . '/js/jquery.anythingslider.js', array(
            'jquery'
        ), true);
		wp_enqueue_script('pmc_any');
		
        wp_register_script('pmc_any_fx', get_template_directory_uri() . '/js/jquery.anythingslider.fx.js', array(
            'jquery'
        ), true);		
		wp_enqueue_script('pmc_any_fx');
		
        wp_register_script('pmc_isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array(
            'jquery'
        ), true);  
		wp_enqueue_script('pmc_isotope');				
        wp_register_script('pmc_ba-bbq', get_template_directory_uri() . '/js/jquery.ba-bbq.js', array(
            'jquery'
        ), true);  
		wp_enqueue_script('pmc_ba-bbq');	
        wp_register_script('pmc_contact', get_template_directory_uri() . '/js/contact.js', array(
            'jquery'
        ), true);  
		wp_enqueue_script('pmc_contact');		
       wp_register_script('pmc_news', get_template_directory_uri() . '/js/jquery.li-scroller.1.0.js', array(
            'jquery'
        ), true);  
		wp_enqueue_script('pmc_news');	
		
        wp_register_script('pmc_gistfile', get_template_directory_uri() . '/js/gistfile_pmc.js', array(
            'jquery'
        ) ,'',true);  
		wp_enqueue_script('pmc_gistfile');

        wp_register_script('pmc_accordian', get_template_directory_uri() . '/js/jquery-ui-1.8.20.custom.min.js', array(
            'jquery'
        ) ,'',true);  
		wp_enqueue_script('pmc_accordian');		

			
	
		

    }
}
add_action('init', 'js_inc_function');

//css
function enqueue_css() {
	global $data; 
    if( !is_admin()){
		wp_register_style('main', get_template_directory_uri() . '/style.css', 'style');
		wp_enqueue_style( 'main');
		wp_register_style('options', get_template_directory_uri() . '/css/options.css', 'style');
		wp_enqueue_style( 'options');	
		wp_register_style('prettyp', get_template_directory_uri() . '/prettyPhoto.css', 'style');
		wp_enqueue_style( 'prettyp');
		wp_register_style('googleFont', 'http://fonts.googleapis.com/css?family='.$data['heading_font']['face'] ,'',NULL);
		wp_enqueue_style( 'googleFont');		
		wp_register_style('accordiancss', get_template_directory_uri() . 'js/jquery-ui-1.8.css' ,'',NULL);
		wp_enqueue_style( 'accordiancss');
		
		
	}
}
add_action('init', 'enqueue_css');


?>
<?php
global $data; 
$use_bg = ''; $background = ''; $custom_bg = ''; $body_face = ''; $use_bg_header =''; $background_header = ''; $custom_bg_header = '';

if(isset($data['background_image'])) {
	$use_bg = $data['background_image'];
}


if(isset($data['background_image_header'])) {
	$use_bg_header = $data['background_image_header'];
}

if($use_bg_header) {

	$custom_bg = $data['body_bg_custom'];
	
	if(!empty($custom_bg)) {
		$bg_img = $custom_bg;
	} else {
		$bg_img = $data['body_bg'];
	}
	
	$bg_prop = $data['body_bg_properties'];
	
	$background = 'url('. $bg_img .') '.$bg_prop ;

}



if($use_bg_header) {

	$custom_bg_header = $data['header_bg_custom'];
	
	if(!empty($custom_bg)) {
		$bg_img_header = $custom_bg;
	} else {
		$bg_img_header = $data['header_bg'];
	}
	
	$bg_prop_header = $data['header_bg_properties'];
	
	$background_header = 'url('. $bg_img_header .') '.$bg_prop_header ;

}

function ieOpacity($opacityIn){
	
	$opacity = explode('.',$opacityIn);
	if($opacity[0] == 1)
		$opacity = 100;
	else
		$opacity = $opacity[1] * 10;
		
	return $opacity;
}

function HexToRGB($hex,$opacity) {
		$hex = ereg_replace("#", "", $hex);
		$color = array();
 
		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}
 
		return 'rgba('.$color['r'] .','.$color['g'].','.$color['b'].','.$opacity.')';
	}
	


?>
::selection { background: <?php echo $data['mainColor']; ?>; color: #fff; text-shadow: none; }
body {	 
	background:<?php echo $data['body_background_color']; ?>  url('<?php echo $data['body_bg']; ?>') !important;
	color:<?php echo $data['body_font']['color']; ?>;
	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
	font-size: <?php echo $data['body_font']['size']; ?>;
	line-height: 1.65em;
	letter-spacing: normal;
}
h1,h2,h3,h4,h5,h6{
	font-family: <?php echo str_replace("%20"," ",$data['heading_font']['face']); ?> !important;
	line-height: 110%;
}

h1 { 	
	color:<?php echo $data['heading_font_h1']['color']; ?>;
	font-size: <?php echo $data['heading_font_h1']['size'] ?> !important;
	}
	
h2{ 	
	color:<?php echo $data['heading_font_h2']['color']; ?>;
	font-size: <?php echo $data['heading_font_h2']['size'] ?> !important;
	}

h3 { 	
	color:<?php echo $data['heading_font_h3']['color']; ?>;
	font-size: <?php echo $data['heading_font_h3']['size'] ?> !important;
	}

h4 { 	
	color:<?php echo $data['heading_font_h4']['color']; ?>;
	font-size: <?php echo $data['heading_font_h4']['size'] ?> !important;
	}	
	
h5 { 	
	color:<?php echo $data['heading_font_h5']['color']; ?>;
	font-size: <?php echo $data['heading_font_h5']['size'] ?> !important;
	}	

h6 { 	
	color:<?php echo $data['heading_font_h6']['color']; ?>;
	font-size: <?php echo $data['heading_font_h6']['size'] ?> !important;
	}		
a:hover {color: <?php echo $data['mainColor']; ?>;}

/* ***********************
--------------------------------------
------------NIVO SLIDER----------
--------------------------------------
*********************** */
.homeBox h2 a {color:<?php echo $data['heading_font_h3']['color']; ?>;}
.nivo-caption { 
	background-image: url(images/mainContentPattern.png);
	position:absolute; 
	color: <?php echo $data['slider_fontSize_colorNivo']['color']; ?>; 
	font-size: <?php echo $data['slider_fontSize_colorNivo']['size']; ?>;
	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif; 
	background-color:#fff;
	background-color: <?php echo HexToRGB($data['slider_backColorNivo'],$data['slider_opacity']) ?>;
	text-shadow:0 1px 0 <?php echo HexToRGB($data['ShadowColorFont'],$data['ShadowOpacittyColorFont'])?>;

	letter-spacing: normal;
	padding:5px;
	z-index:99;
	top:15px;
	left:15px;
}



.nivo-caption a { 
	color: <?php echo $data['slider_fontSize_colorNivo']['color']; ?>;  
	text-decoration: underline; 
}	

.caption-content { padding:0px 0px 200px 0px; color:<?php echo $data['slider_fontSize_color']['color']; ?>; font-size: <?php echo $data['slider_fontSize_color']['size']; ?>; font-family: "Helvetica Neue", Arial, Helvetica, sans-serif; text-shadow: 1px 1px 0px black; filter:alpha(opacity=<?php echo ieOpacity($data['slider_opacity']); ?>);letter-spacing: normal;}
.caption-content h1{width:250px !important; background: <?php echo HexToRGB($data['mainColor'],$data['slider_opacity']) ?>;  padding:10px ;text-align:center;  line-height:120%;}
.caption-content h2 {	color:<?php echo $data['slider_fontSize_color']['color'] ;?>!important;
						font-size:<?php echo $data['slider_fontSize_color']['size'] ;?>!important;
						text-shadow: 1px 1px 0px black;}
.caption-content p{ }
.blogpostcategory h2 a, .textlink {font-family: <?php echo str_replace("%20"," ",$data['heading_font']['face']); ?> !important;color:<?php echo $data['heading_font_h2']['color']; ?>;}



.caption-content h1{
	color:<?php echo $data['slider_HfontSize_color']['color'] ;?>!important;
	font-size:<?php echo $data['slider_HfontSize_color']['size'] ;?>!important;
	text-shadow: 1px 1px 0px black;
}

.caption-content h2{
	background: <?php echo HexToRGB($data['slider_backColor'], $data['slider_opacity']); ?>;  padding:10px ;text-align:center;  line-height:120%;
}
/* ***********************
--------------------------------------
------------MAIN COLOR----------
--------------------------------------
*********************** */

.item h3 a:hover, .item2 h3 a:hover, .item4 h3 a:hover,.homeRacent h3:hover,.catlink:hover,.infotext span, .homeRacent h3 a:hover, .homeBox h2 a:hover,
.blogpost .link:hover,.blogpost .postedin:hover ,.blogpost .postedin:hover, .blogpost .link a:hover,.blogpostcategory a.textlink:hover,
.footer_widget .widget_links ul li a:hover, .footer_widget .widget_categories  ul li a:hover,  .footer_widget .widget_archive  ul li a:hover,
#footerb .footernav ul li a:hover,.footer_widget  ul li a:hover,.tags span a:hover,.more-link:hover,.homeBox .one_third a,.showpostpostcontent h1 a:hover,
.menu li ul li:hover a,.menu li a:hover strong,.menu li ul li:hover ul li a,.menu li ul li:hover ul li:hover a,.menu li ul li:hover ul li:hover ul li a,.menu li ul li:hover ul li:hover ul li:hover a,
.menu > li.current-menu-item a strong,.menu > li.current-menu-ancestor a strong,.blogpostcategory .meta .written:hover a ,.blogpostcategory .meta .comments:hover a ,
.blogpostcategory .meta .category:hover a,.blogpostcategory h2 a:hover,#wp-calendar a , .widgett a:hover ,.widget_categories li.current-cat a, .widget_categories li.current-cat, .blogpostcategory .meta .time a:hover, .error404 .postcontent h1
{color:<?php echo $data['mainColor']; ?> !important;}


/* ***********************
--------------------------------------
------------BOX COLOR----------
--------------------------------------
*********************** */
#header, #nslider-wrapper,#remove ,#footer,.homeRacent h3, #homeRecent .one_fourth, .item h3, .item4 h3, .item h3 a, .item4 h3 a ,.item ,.item4,.homewrap .homesingleleft,.homewrap .homesingleright,.projectdetails,
.projectdescription, .widget
{background-image: url(images/mainContentPattern.png); background:<?php echo $data['boxColor']; ?>}
.homeRacent h3 a, .item h3, .item4 h3, .item h3 a, .item4 h3 a {color:<?php echo $data['body_font']['color']; ?>;}
#remove a {color:<?php echo $data['body_font']['color']; ?>;}

/* ***********************
--------------------------------------
------------MAIN COLOR BOXED----------
--------------------------------------
*********************** */
#footerbwrap,.catlinkhover,#contactform  .contactbutton .contact-button:hover,#commentform #respond #commentform input#commentSubmit:hover, #respond #commentform input#commentSubmit:hover
{background:<?php echo $data['mainColor']; ?>;  background-image: url(images/mainContentPattern.png);color:#1e1e20;}

 .catlinkhover, #remove a:hover,.wp-pagenavi a:hover, .wp-pagenavi span.current {color:<?php echo $data['portfolioColor']; ?> !important;background:<?php echo $data['mainColor']; ?>;  background-image: url(images/mainContentPattern.png);}
/* ***********************
--------------------------------------
------------MAIN BORDER COLOR----------
--------------------------------------
*********************** */
#header, .recentborder,.item4 .recentborder, .item .recentborder,.afterlinehome,.prelinehome{border-color:<?php echo $data['mainColor']; ?> !important;}

.homeRacent .overLowerDefault,.item .overLowerDefault,.item4 .overLowerDefault{ 	
	border-left:5px solid <?php echo $data['mainColor']; ?>;
	border-right:5px solid <?php echo $data['mainColor']; ?>;
}
/* ***********************
--------------------------------------
------------BODY COLOR----------
--------------------------------------
*********************** */

.blogpost .link a,.datecomment span,.homesingleleft .tags a,.homesingleleft .postedin a,.blogpostcategory .category a,.blogpostcategory .comments a,
.blogpostcategory a.textlink ,.written a, .blogpostcategory .meta .time a	
{ color:<?php echo $data['body_font']['color']; ?>}


/* ***********************
--------------------------------------
------------MENU----------
--------------------------------------
*********************** */

.menu li:hover ul {border-bottom: 1px solid <?php echo $data['mainColor']; ?>; border-left: 1px solid <?php echo $data['mainColor']; ?>; border-right: 1px solid <?php echo $data['mainColor']; ?>;}
.menu li ul li a{	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif !important; }
.menu > li a {	font-family: <?php echo str_replace("%20"," ",$data['heading_font']['face']); ?> !important; color:#2e2d2d !important;letter-spacing: normal;}
.menu a span{ 	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif; color:#aaa !important;letter-spacing: normal;}
<?php echo $data['heading_font_h1']['color']; ?>

/* ***********************
--------------------------------------
------------BLOG----------
-----------------------------------*/
.blogpostcategory h2 {line-height: 110% !important;}
.wp-pagenavi span.pages {font-family: <?php echo str_replace("%20"," ",$data['heading_font']['face']); ?> !important;}
.wp-pagenavi a, .showpostpostcontent h1 a {color:<?php echo $data['heading_font_h2']['color']; ?>;}
.wp-pagenavi a:hover, ul.tabs a.current, ul.tabs a:hover, h2.trigger:hover { color:<?php echo $data['mainColor']; ?>; }
.blogpost .datecomment a, .tags a, .related h4 a, .content ol.commentlist li .comment-author .fn a, .content ol.commentlist li .reply a {color:<?php echo $data['body_font']['color']; ?>;}
.blogpost .datecomment a:hover, .tags a:hover, .related h4 a:hover, .content ol.commentlist li .comment-author .fn a:hover, .content ol.commentlist li .reply a:hover { color:<?php echo $data['mainColor']; ?>; }
.content ol.commentlist li .reply a, .comment-author .fn a{font-family: <?php echo str_replace("%20"," ",$data['heading_font']['face']); ?> !important;}
.image-gallery, .gallery-item { border: 1px dashed <?php echo $data['mainColor']; ?>;}

/* ***********************
--------------------------------------
------------Widget----------
-----------------------------------*/
.wttitle a {color:<?php echo $data['heading_font_h4']['color']; ?>;}
.widget{border-top:5px solid <?php echo $data['mainColor']; ?>;border-bottom:1px solid #CFCFCF;}
.widgetline{<?php echo $bordersidebar; ?>}
.widgett a:hover, .widget_nav_menu ul li a:hover{color:<?php echo $data['mainColor']; ?> !important;}
.item h4, .item2 h4, .item4 h4{	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif !important; }
.related h4{	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif !important; }
.widget_search form div {	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif !important;}
.widgett a {	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif !important;}
.widget_tag_cloud a{	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif !important;}



/* ***********************
--------------------------------------
------------BUTTONS WITH SHORTCODES----------
--------------------------------------
*********************** */

.button_purche_right_top,.button_download_right_top,.button_search_right_top {font-family: <?php echo str_replace("%20"," ",$data['heading_font']['face']); ?> !important;color:<?php echo $data['heading_font_h2']['color']; ?>;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);}
.button_purche:hover,.button_download:hover,.button_search:hover {color:<?php echo $data['mainColor']; ?> !important;}
.ribbon_center_red a, .ribbon_center_blue a, .ribbon_center_white a, .ribbon_center_yellow a, .ribbon_center_green a {font-family: <?php echo str_replace("%20"," ",$data['heading_font']['face']); ?> !important;}

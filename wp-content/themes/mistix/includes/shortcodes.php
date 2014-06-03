<?php

//question
function shortcode_question($atts, $content=null){
return '<div class="question"><span class="img"></span><h3>'.$content.'</h3></div>';	
}
add_shortcode('question', 'shortcode_question');

//success
function shortcode_success($atts, $content=null){
return '<div class="success"><span class="img"></span><h3>'.$content.'</h3></div>';	
}
add_shortcode('success', 'shortcode_success');

//info
function shortcode_info($atts, $content=null){
return '<div class="info"><span class="img"></span><h3>'.$content.'</h3></div>';	
}
add_shortcode('info', 'shortcode_info');

//error
function shortcode_error($atts, $content=null){
return '<div class="error"><span class="img"></span><h3>'.$content.'</h3></div>';
}
add_shortcode('error', 'shortcode_error');

//full
function shortcode_full($atts, $content = null){
return '<div class="full">' . do_shortcode($content) . '</div>';
}
add_shortcode('full', 'shortcode_full');

//half
function shortcode_half($atts, $content = null){
return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('half', 'shortcode_half');

//half last
function shortcode_half_last($atts, $content = null){
return '<div class="one_half last">' . do_shortcode($content) . '</div>';
}
add_shortcode('half_last', 'shortcode_half_last');

//one third
function shortcode_onethird($atts, $content=null){
return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'shortcode_onethird');

//one third last
function shortcode_onethird_last($atts, $content=null){
return '<div class="one_third last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third_last', 'shortcode_onethird_last');

//one fourth
function shortcode_onefourth($atts, $content=null){
return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'shortcode_onefourth');

//one fourth last
function shortcode_onefourth_last($atts, $content=null){
return '<div class="one_fourth last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth_last', 'shortcode_onefourth_last');

//two thirds
function shortcode_twothirds($atts, $content=null){
return '<div class="two_thirds">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds', 'shortcode_twothirds');

//three fourths
function shortcode_threefourths($atts, $content=null){
return '<div class="three_fourths">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourths', 'shortcode_threefourths');

//three fourths last 
function shortcode_threefourths_last($atts, $content=null){
return '<div class="three_fourths last">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourths_last', 'shortcode_threefourths_last');

//one fifth 
function shortcode_onefifth($atts, $content=null){
return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'shortcode_onefifth');

//one fifth  last 
function shortcode_onefifth_last($atts, $content=null){
return '<div class="one_fifth last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth_last', 'shortcode_onefifth_last');

//four fifths  
function shortcode_fourfifths($atts, $content=null){
return '<div class="four_fifths">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifths', 'shortcode_fourfifths');

//four fifths last
function shortcode_fourfifths_last($atts, $content=null){
return '<div class="four_fifths last">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifths_last', 'shortcode_fourfifths_last');

//break
function shortcode_break($atts, $content=null){
return '<div class="break clearfix">&nbsp;</div>';
}
add_shortcode('break', 'shortcode_break');

//divider
function shortcode_divider($atts, $content=null){
return '<div class="divider clearfix">&nbsp;</div>';
}
add_shortcode('divider', 'shortcode_divider');

//divider top
function shortcode_dividertop( $atts, $content = null ) {
return '<div class="totop"><div class="gototop"></div></div>';
}
add_shortcode('dividertop', 'shortcode_dividertop');

//ribbon red
function shortcode_ribbon_red($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
return '<div class="ribbon"><div class="ribbon_left_red"></div><div class="ribbon_center_red"><a href ="'.$url.'">' .do_shortcode($content). '</a></div><div class="ribbon_right_red"></div></div>';
}
add_shortcode('ribbon_red', 'shortcode_ribbon_red');

//ribbon blue
function shortcode_ribbon_blue($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
return '<div class="ribbon"><div class="ribbon_left_blue"></div><div class="ribbon_center_blue"><a href ="'.$url.'">' .do_shortcode($content). '</a></div><div class="ribbon_right_blue"></div></div>';
}
add_shortcode('ribbon_blue', 'shortcode_ribbon_blue');

//ribbon yellow
function shortcode_ribbon_yellow($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
return '<div class="ribbon"><div class="ribbon_left_yellow"></div><div class="ribbon_center_yellow"><a href ="'.$url.'">' .do_shortcode($content). '</a></div><div class="ribbon_right_yellow"></div></div>';
}
add_shortcode('ribbon_yellow', 'shortcode_ribbon_yellow');

//ribbon green
function shortcode_ribbon_green($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
return '<div class="ribbon"><div class="ribbon_left_green"></div><div class="ribbon_center_green"><a href ="'.$url.'">' .do_shortcode($content). '</a></div><div class="ribbon_right_green"></div></div>';
}
add_shortcode('ribbon_green', 'shortcode_ribbon_green');

//ribbon green
function shortcode_ribbon_white($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
return '<div class="ribbon"><div class="ribbon_left_white"></div><div class="ribbon_center_white"><a href ="'.$url.'">' .do_shortcode($content). '</a></div><div class="ribbon_right_white"></div></div>';
}
add_shortcode('ribbon_white', 'shortcode_ribbon_white');

//high light dark
function shortcode_highlight_black($atts, $content=null){
return '<span class="black" >' .$content. '</span>';
}
add_shortcode('highlight_black', 'shortcode_highlight_black');


//high light yellow
function shortcode_highlight_yellow($atts, $content=null){
return '<span class="yellow" >' .$content. '</span>';
}
add_shortcode('highlight_yellow', 'shortcode_highlight_yellow');


//high light blue
function shortcode_highlight_blue($atts, $content=null){
return '<span class="blue" >' .$content. '</span>';
}
add_shortcode('highlight_blue', 'shortcode_highlight_blue');


//high light green
function shortcode_highlight_green($atts, $content=null){
return '<span class="green" >' .$content. '</span>';
}
add_shortcode('highlight_green', 'shortcode_highlight_green');


//list arrow
function shortcode_list_arrow($atts, $content=null){
return '<ul class="arrow" >' .$content. '</ul>';
}
add_shortcode('list_arrow', 'shortcode_list_arrow');

//list arrow point
function shortcode_list_arrow_point($atts, $content=null){
return '<ul class="arrow_point" >' .$content. '</ul>';
}
add_shortcode('list_arrow_point', 'shortcode_list_arrow_point');

//list circle
function shortcode_list_circle($atts, $content=null){
return '<ul class="circle" >' .$content. '</ul>';
}
add_shortcode('list_circle', 'shortcode_list_circle');


//list tick
function shortcode_list_tick($atts, $content=null){
return '<ul class="ticklist" >' .$content. '</ul>';
}
add_shortcode('list_tick', 'shortcode_list_tick');

//list comment
function shortcode_list_comment($atts, $content=null){
return '<ul class="commentlistshort" >' .$content. '</ul>';
}
add_shortcode('list_comment', 'shortcode_list_comment');

//list mail
function shortcode_list_mail($atts, $content=null){
return '<ul class="maillist" >' .$content. '</ul>';
}
add_shortcode('list_mail', 'shortcode_list_mail');

//list plus
function shortcode_list_plus($atts, $content=null){
return '<ul class="pluslist" >' .$content. '</ul>';
}
add_shortcode('list_plus', 'shortcode_list_plus');

//list ribbon
function shortcode_list_ribbon($atts, $content=null){
return '<ul class="ribbonlist" >' .$content. '</ul>';
}
add_shortcode('list_ribbon', 'shortcode_list_ribbon');

//list settings
function shortcode_list_settings($atts, $content=null){
return '<ul class="settingslist" >' .$content. '</ul>';
}
add_shortcode('list_settings', 'shortcode_list_settings');

//list star
function shortcode_list_star($atts, $content=null){
return '<ul class="starlist" >' .$content. '</ul>';
}
add_shortcode('list_star', 'shortcode_list_star');

//list image
function shortcode_list_image($atts, $content=null){
return '<ul class="imagelist" >' .$content. '</ul>';
}
add_shortcode('list_image', 'shortcode_list_image');

//list link
function shortcode_list_link($atts, $content=null){
return '<ul class="linklist" >' .$content. '</ul>';
}
add_shortcode('list_link', 'shortcode_list_link');

//text
function shortcode_slogan ($atts, $content=null){
return '<span class="slogan" >' . do_shortcode($content) . '</span>';
}
add_shortcode('slogan', 'shortcode_slogan');

//dropcap
function shortcode_dropcap($atts, $content=null) {
return '<div class="dropcap">' .$content. '</div>';
}
add_shortcode('dropcap', 'shortcode_dropcap');

//button dark
function shortcode_button_dark($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttondark">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_dark', 'shortcode_button_dark');

//button blue
function shortcode_button_blue($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonblue">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_blue', 'shortcode_button_blue');

//button green
function shortcode_button_green($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttongreen">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_green', 'shortcode_button_green');

//button pink
function shortcode_button_pink($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonpink">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_pink', 'shortcode_button_pink');

//button yellow
function shortcode_button_yellow($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonyellow">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_yellow', 'shortcode_button_yellow');

//button orange
function shortcode_button_orange($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonorange">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_orange', 'shortcode_button_orange');

//button orange modern
function shortcode_button_orange_modern($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonorange_modern">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_orange_modern', 'shortcode_button_orange_modern');

//button red
function shortcode_button_red($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonred">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_red', 'shortcode_button_red');


//button dark modern
function shortcode_button_dark_modern($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttondark_modern">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_dark_modern', 'shortcode_button_dark_modern');

//button blue
function shortcode_button_blue_modern($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonblue_modern">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_blue_modern', 'shortcode_button_blue_modern');

//button green
function shortcode_button_green_modern($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttongreen_modern">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_green_modern', 'shortcode_button_green_modern');

//button pink
function shortcode_button_pink_modern($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonpink_modern">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_pink_modern', 'shortcode_button_pink_modern');

//button yellow
function shortcode_button_yellow_modern($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonyellow_modern">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_yellow_modern', 'shortcode_button_yellow_modern');

//button grey
function shortcode_button_grey_modern($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttongrey_modern">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_grey_modern', 'shortcode_button_grey_modern');

//button red
function shortcode_button_red_modern($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"iconlink" =>''
	), $atts));
	$image = '';
	if($iconlink == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$iconlink.'" /></div>';
return '<div class="buttonshort"><div class="buttonred_modern">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.do_shortcode($content).'</a></div></div></div>';
}
add_shortcode('button_red_modern', 'shortcode_button_red_modern');

//button buy
function shortcode_button_purche($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"bottom_text"=>''
	), $atts));
return '<div class="button_purche"><a href="'.$url.'"><div class="button_purche_left"></div><div class="button_purche_right"><div class="button_purche_right_top">'.do_shortcode($content).'</div><div class="button_purche_right_bottom">'.$bottom_text.'</div></div></a></div>';
}
add_shortcode('button_purche', 'shortcode_button_purche');

//button download
function shortcode_button_download($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"bottom_text"=>''
	), $atts));
return '<div class="button_download"><a href="'.$url.'"><div class="button_download_left"></div><div class="button_download_right"><div class="button_download_right_top">'.do_shortcode($content).'</div><div class="button_download_right_bottom">'.$bottom_text.'</div></div></a></div>';
}
add_shortcode('button_download', 'shortcode_button_download');

//button search
function shortcode_button_search_c($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"bottom_text"=>''
	), $atts));
return '<div class="button_search"><a href="'.$url.'"><div class="button_search_left"></div><div class="button_search_right"><div class="button_search_right_top">'.do_shortcode($content).'</div><div class="button_search_right_bottom">'.$bottom_text.'</div></div></a></div>';
}
add_shortcode('button_search_c', 'shortcode_button_search_c');

//progressbar
function shortcode_progressbar($atts, $content = null) {
	extract(shortcode_atts(array(
		"progress" => '',
		"color"=>''
	), $atts));

return '<h4>'.do_shortcode($content).'</h4><div class="progressbar ui-widget ui-widget-content ui-corner-all">
   <div style="width: '.$progress.'%; background-color:'.$color.'" class="ui-progressbar-value ui-widget-header ui-corner-left"></div>
</div>';
}
add_shortcode('progressbar', 'shortcode_progressbar');

//toggle
function shortcode_toggle($atts, $content = null){
	extract(shortcode_atts(array(
		'title' => ''
	), $atts));
return '<div class="block"><h2 class="trigger">'.$title.'</h2>
<div class="toggle_container">' . do_shortcode($content) . '</div></div>';
}
add_shortcode('toggle', 'shortcode_toggle');

//pull quote
function shortcode_pullquote( $atts, $content = null ) {
return '<blockquote class="pullquote">' . $content . '</blockquote>';
}
add_shortcode('pull', 'shortcode_pullquote');

//push quote
function shortcode_pushquote( $atts, $content = null ) {
return '<blockquote class="pushquote">' . $content . '</blockquote>';
}
add_shortcode('push', 'shortcode_pushquote');

add_filter('widget_text', 'do_shortcode');
//button search


//accordion
add_shortcode( 'accordion', 'short_accordions' );
function short_accordions( $atts, $content ){
$GLOBALS['atab_count'] = 0;

do_shortcode( $content );
$content = '';
if( is_array( $GLOBALS['atabs'] ) ){
foreach( $GLOBALS['atabs'] as $tab ){
$content .= '<h3><a href="#">'.$tab['title'].'</a></h3>';
$content .= '<div>'.$tab['content'].'</div>';
}
$return = '<div class="accordion">'.$content.'</div>'."\n";
}
return $return;
}

add_shortcode( 'atab', 'short_accordion' );
function short_accordion( $atts, $content ){
extract(shortcode_atts(array(
'title' => 'Tab %d'
), $atts));

$x = $GLOBALS['atab_count'];
$GLOBALS['atabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['atab_count'] ), 'content' =>  $content );

$GLOBALS['atab_count']++;
}

//nivo thumb


add_shortcode( 'nivot', 'short_nivost' );
function short_nivost( $atts, $content ){
$GLOBALS['nttab_count'] = 0;
global $data; 
do_shortcode( $content );
$content = '';
if( is_array( $GLOBALS['nttabs'] ) ){
foreach( $GLOBALS['nttabs'] as $tab ){
if($tab['link'] != '')
$content .= '<a href="'.$tab['link'] .'"><img style="height:'.$tab['height'].'px;width:'.$tab['width'].'px" src="'. get_template_directory_uri() .'/js/timthumb.php?src='. $tab['imageurl'] .'&amp;h='.$tab['height'].'&amp;w='.$tab['width'].'" title="'. stripText($tab['title']) .'" rel="'. get_template_directory_uri() .'/js/timthumb.php?src='. $tab['imageurl'] .'&amp;h=65&amp;w=110"></a>';
else
$content .= '<img style="height:'.$tab['height'].'px;width:'.$tab['width'].'px" src="'. get_template_directory_uri() .'/js/timthumb.php?src='. $tab['imageurl'] .'&amp;h='.$tab['height'].'&amp;w='.$tab['width'].'" title="'. stripText($tab['title']) .'" rel="'. get_template_directory_uri() .'/js/timthumb.php?src='. $tab['imageurl'] .'&amp;h=65&amp;w=110">';


}
$return = "<script>jQuery(document).ready(function () {
jQuery('#nslidert').nivoSlider({
		effect:'".$data['effect'] ."', // Specify sets like: 'fold,fade,sliceDown'
        slices:". $data['slices'] .", // For slice animations
        boxCols: ". $data['boxcols'] .", // For box animations
        boxRows: ". $data['boxrows'] .", // For box animations
        animSpeed:". $data['anispeed'] .", // Slide transition speed
        pauseTime:". $data['pausetime'].", // How long each slide will show
        startSlide:0, // Set starting Slide (0 index)
        directionNav:false, // Next & Prev navigation
        directionNavHide:true, // Only show on hover
		controlNav:true, // 1,2,3... navigation
		pauseOnHover:false,
		controlNavThumbs: true,
		controlNavThumbsFromRel: true,
		controlNavThumbsSearch: '',
		controlNavThumbsReplace: '',
		captionOpacity:1 
    });
});	</script><div id='nslidert' class='nivoSlidert' style='height:".$tab['height']."px;width:".$tab['width']."px;margin-bottom:10px;margin-left:0;'>".$content."</div>";

}
return $return;
}

add_shortcode( 'nttab', 'short_nivot' );
function short_nivot( $atts, $content ){
extract(shortcode_atts(array(
'title' => 'Tab %d',
'imageurl' => '',
'link' => '',
'width' => '600',
'height' => '300'
), $atts));

$x = $GLOBALS['nttab_count'];
$GLOBALS['nttabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['nttab_count'] ) ,'imageurl' => sprintf( $imageurl, $GLOBALS['nttab_count'] ),'link' => sprintf( $link, $GLOBALS['nttab_count'] ),'width' => sprintf( $width, $GLOBALS['nttab_count'] ),'height' => sprintf( $height, $GLOBALS['nttab_count'] ),'content' =>  $content );

$GLOBALS['nttab_count']++;
}

//nivo


add_shortcode( 'nivo', 'short_nivos' );
function short_nivos( $atts, $content ){
$GLOBALS['ntab_count'] = 0;
global $data; 
do_shortcode( $content );
$content = '';
if( is_array( $GLOBALS['ntabs'] ) ){
foreach( $GLOBALS['ntabs'] as $tab ){
if($tab['link'] != '')
$content .= '<a href="'.$tab['link'] .'"><img style="height:'.$tab['height'].'px;width:'.$tab['width'].'px" src="'. get_template_directory_uri() .'/js/timthumb.php?src='. $tab['imageurl'] .'&amp;h='.$tab['height'].'&amp;w='.$tab['width'].'" title="'. stripText($tab['title']) .'"></a>';
else
$content .= '<img style="height:'.$tab['height'].'px;width:'.$tab['width'].'px" src="'. get_template_directory_uri() .'/js/timthumb.php?src='. $tab['imageurl'] .'&amp;h='.$tab['height'].'&amp;w='.$tab['width'].'" title="'. stripText($tab['title']) .'">';


}
$return = "<script>jQuery(document).ready(function () {
jQuery('.nivoSlider').nivoSlider({
		effect:'".$data['effect'] ."', // Specify sets like: 'fold,fade,sliceDown'
        slices:". $data['slices'] .", // For slice animations
        boxCols: ". $data['boxcols'] .", // For box animations
        boxRows: ". $data['boxrows'] .", // For box animations
        animSpeed:". $data['anispeed'] .", // Slide transition speed
        pauseTime:". $data['pausetime'].", // How long each slide will show
        startSlide:0, // Set starting Slide (0 index)
        directionNav:true, // Next & Prev navigation
        directionNavHide:true, // Only show on hover
		controlNav:false, // 1,2,3... navigation
		pauseOnHover:false,
		captionOpacity:1 
    });
});	</script><div id='nslider' class='nivoSlider' style='height:".$tab['height']."px;width:".$tab['width']."px;margin-bottom:10px;margin-left:0;'>".$content."</div>";

}
return $return;
}

add_shortcode( 'ntab', 'short_nivo' );
function short_nivo( $atts, $content ){
extract(shortcode_atts(array(
'title' => 'Tab %d',
'imageurl' => '',
'link' => '',
'width' => '600',
'height' => '300'
), $atts));

$x = $GLOBALS['ntab_count'];
$GLOBALS['ntabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['ntab_count'] ) ,'imageurl' => sprintf( $imageurl, $GLOBALS['ntab_count'] ),'link' => sprintf( $link, $GLOBALS['ntab_count'] ),'width' => sprintf( $width, $GLOBALS['ntab_count'] ),'height' => sprintf( $height, $GLOBALS['ntab_count'] ),'content' =>  $content );

$GLOBALS['ntab_count']++;
}

//tabs
add_shortcode( 'tabgroup', 'fl_tabs' );
function fl_tabs( $atts, $content ){
$GLOBALS['tab_count'] = 0;

do_shortcode( $content );

if( is_array( $GLOBALS['tabs'] ) ){
foreach( $GLOBALS['tabs'] as $tab ){
$tabs[] = '<li><a href="#">'.$tab['title'].'</a></li>';
$panes[] = '<div class="pane"><h3>'.$tab['title'].'</h3>'.$tab['content'].'</div>';
}
$return = "\n".'<!-- the tabs --><div class="tabwrap"><ul class="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<!-- tab "panes" --><div class="panes">'.implode( "\n", $panes ).'</div></div>'."\n";
}
return $return;
}

add_shortcode( 'tab', 'fl_tab' );
function fl_tab( $atts, $content ){
extract(shortcode_atts(array(
'title' => 'Tab %d'
), $atts));

$x = $GLOBALS['tab_count'];
$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );

$GLOBALS['tab_count']++;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

?>
<?php file_exists('../../../../wp-load.php') ? require_once('../../../../wp-load.php') : require_once('../../../../../wp-load.php'); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title></title>

	<link rel="stylesheet" type="text/css" href="shortcode_styles.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
    <script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#insert').attr("disabled", true);
			jQuery('#insert').addClass("disabled");
			jQuery('#select_shortcode').change(function() {
				if( jQuery(this).val() == '' ) {
					jQuery('#insert').attr("disabled", true);
					jQuery('#insert').addClass("disabled");
				} else {
					jQuery('#insert').removeAttr("disabled");
					jQuery('#insert').removeClass("disabled");
				}
			});
		});
		
		function returnShortcodeValue() {
			var out;
			
			switch(jQuery('#select_shortcode').val())
			{
				case "one_half": 
					out = "[half]<p>Your content here...</p>[/half]<br />";
					break;
				case "one_half_last": 
					out = "[half_last]<p>Your content here...</p>[/half_last]<br />";
					break;
				case "one_third": 
					out = "[one_third]<p>Your content here...</p>[/one_third]<br />";
					break;
				case "one_third_last": 
					out = "[one_third_last]<p>Your content here...</p>[/one_third_last]<br />";
					break;
				case "two_thirds": 
					out = "[two_thirds]p>Your content here...</p>[/two_thirds]<br />";
					break;
				case "two_thirds_last": 
					out = "[two_thirds_last]<p>Your content here...</p>[/two_thirds_last]<br />";
					break;
				case "one_fourth": 
					out = "[one_fourth]<p>Your content here...</p>[/one_fourth]<br />";
					break;
				case "one_fourth_last": 
					out = "[one_fourth_last]<p>Your content here...</p>[/one_fourth_last]<br />";
					break;
				case "three_fourths": 
					out = "[three_fourths]<p>Your content here...</p>[/three_fourths]<br />";
					break;
				case "three_fourths_last": 
					out = "[three_fourths_last]<p>Your content here...</p>[/three_fourths_last]<br />";
					break;
				case "one_fifth": 
					out = "[one_fifth]<p>Your content here...</p>[/one_fifth]<br />";
					break;
				case "one_fifth_last": 
					out = "[one_fifth_last]<p>Your content here...</p>[/one_fifth_last]<br />";
					break;
				case "button_purche":
					out = "[button_purche url=http://www.google.com bottom_text=\"add boottom text for purche button\"]Purche[/button_purche]<br />";
					break;	
			case "button_download":
					out = "[button_download url=http://www.google.com bottom_text=\"add boottom text for download button\"]Download[/button_download]<br />";
					break;		
				case "button_search_c":
					out = "[button_search_c url=http://www.google.com bottom_text=\"add boottom text for search button\"]Search[/button_search_c]<br />";
					break;						
				case "button_dark":
					out = "[button_dark iconlink=\"\" url=http://www.google.com]Text[/button_dark]<br />";
					break;
				case "button_blue":
					out = "[button_blue iconlink=\"\" url=http://www.google.com]Text[/button_blue]<br />";
					break;
				case "button_orange":
					out = "[button_orange iconlink=\"\" url=http://www.google.com]Text[/button_orange]<br />";
					break;
				case "button_pink":
					out = "[button_pink iconlink=\"\" url=http://www.google.com]Text[/button_pink]<br />";
					break;
				case "button_yellow":
					out = "[button_yellow iconlink=\"\" url=http://www.google.com]Text[/button_yellow]<br />";
					break;
				case "button_green":
					out = "[button_green iconlink=\"\" url=http://www.google.com]Text[/button_green]<br />";
					break;					
				case "button_red":
					out = "[button_red iconlink=\"\" url=http://www.google.com]Text[/button_red]<br />";
					break;		
				case "button_dark_modern":
					out = "[button_dark_modern iconlink=\"\" url=http://www.google.com]Text[/button_dark_modern]<br />";
					break;
				case "button_blue_modern":
					out = "[button_blue_modern iconlink=\"\" url=http://www.google.com]Text[/button_blue_modern]<br />";
					break;
				case "button_orange_modern":
					out = "[button_orange_modern iconlink=\"\" url=http://www.google.com]Text[/button_orange_modern]<br />";
					break;
				case "button_pink_modern":
					out = "[button_pink_modern iconlink=\"\" url=http://www.google.com]Text[/button_pink_modern]<br />";
					break;
				case "button_yellow_modern":
					out = "[button_yellow_modern iconlink=\"\" url=http://www.google.com]Text[/button_yellow_modern]<br />";
					break;
				case "button_green_modern":
					out = "[button_green_modern iconlink=\"\" url=http://www.google.com]Text[/button_green_modern]<br />";
					break;					
				case "button_red_modern":
					out = "[button_red_modern iconlink=\"\" url=http://www.google.com]Text[/button_red_modern]<br />";
					break;									
				case "ribbon_red":
					out = "[ribbon_red url=http://www.google.com]Ribbon[/ribbon_red]<br />";
					break;		
				case "ribbon_blue":
					out = "[ribbon_blue url=http://www.google.com]Ribbon[/ribbon_blue]<br />";
					break;	
				case "ribbon_white":
					out = "[ribbon_white url=http://www.google.com]Ribbon[/ribbon_white]<br />";
					break;	
				case "ribbon_yellow":
					out = "[ribbon_yellow url=http://www.google.com]Ribbon[/ribbon_yellow]<br />";
					break;	
				case "ribbon_green":
					out = "[ribbon_green url=http://www.google.com]Ribbon[/ribbon_green]<br />";
					break;						
				case "box_1":
					out = "[info]<br />Content...<br />[/info]<br />";
					break;
				case "box_2":
					out = "[success]<br />Content...<br />[/success]<br />";
					break;
				case "box_3":
					out = "[question]<br />Content...<br />[/question]<br />";
					break;
				case "box_4":
					out = "[error]<br />Content...<br />[/error]<br />";
					break;	
				case "progressbar":
					out = "[progressbar progress=30 color=#fff]Title[/progressbar]<br />";
					break;						
				case "accordion":
					out = "[accordion]<br />[atab title=\"First tab\"]Tab content goes here[/atab]<br />[atab title=\"Second tab\"]Tab content goes here[/atab]<br />[atab title=\"Third tab\"]Tab content goes here[/atab]<br /> [/accordion]<br />";
					break;	
				case "nivo":
					out = "[nivo]<br />[ntab title=\"title1\" link=\"link\" imageurl=\"image url\" width=\"600\" height=\"300\"][/ntab]<br />[ntab title=\"title2\" link=\"link\" imageurl=\"image url\" width=\"600\" height=\"300\"][/ntab]<br />[ntab title=\"title3\" link=\"link\" imageurl=\"image url\" width=\"600\" height=\"300\"][/ntab]<br /> [/nivo]<br />";
					break;	
				case "nivot":
					out = "[nivot]<br />[nttab title=\"title1\" link=\"link\" imageurl=\"image url\" width=\"600\" height=\"300\"][/nttab]<br />[nttab title=\"title2\" link=\"link\" imageurl=\"image url\" width=\"600\" height=\"300\"][/nttab]<br />[nttab title=\"title3\" link=\"link\" imageurl=\"image url\" width=\"600\" height=\"300\"][/nttab]<br /> [/nivot]<br />";
					break;					
				case "tabs":
					out = "[tabgroup]<br />[tab title=\"First tab\"]Tab content goes here[/tab]<br />[tab title=\"Second tab\"]Tab content goes here[/tab]<br />[tab title=\"Third tab\"]Tab content goes here[/tab]<br /> [/tabgroup]<br />";
					break;
				case "toggle":
					out = "[toggle title=\"Toggle title...\"]Toggle content...[/toggle]<br />";
					break;
				case "title":
					out = "[title]Title Example[/title]<br />";
					break;
				case "break":
					out = "[break/]<br />";
					break;
				case "totop":
					out = "[dividertop]<br />";
					break;					
				case "dropcap":
					out = "[dropcap]A[/dropcap]<br />";
					break;
				case "list_comment":
					out = "[list_comment]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_comment]<br />";
					break;
				case "list_circle":
					out = "[list_circle]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_circle]<br />";
					break;
				case "list_plus":
					out = "[list_plus]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_plus]<br />";
					break;
				case "list_ribbon":
					out = "[list_ribbon]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_ribbon]<br />";
					break;
				case "list_settings":
					out = "[list_settings]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_settings]<br />";
					break;
				case "list_star":
					out = "[list_star]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_star]<br />";
					break;
				case "list_image":
					out = "[list_image]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_image]<br />";
					break;
				case "list_link":
					out = "[list_link]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_link]<br />";
					break;		
				case "list_mail":
					out = "[list_mail]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_mail]<br />";
					break;						
				case "list_arrow":
					out = "[list_arrow]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_arrow]<br />";
					break;
				case "list_tick":
					out = "[list_tick]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_tick]<br />";
					break;					
				case "list_arrow_point":
					out = "[list_arrow_point]<br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br /><li>list item...</li><br />[/list_arrow_point]<br />";
					break;	
				case "blockquote_left":
					out = "[blockquote align=\"left\"]Lorem ipsum dolor sit amet....[/blockquote]<br />";
					break;
				default: 
					out = '';
			}
			
			window.tinyMCE.execInstanceCommand(window.tinyMCE.activeEditor.editorId, 'mceInsertContent', false, out);
			window.tinyMCE.activeEditor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
    </script>
</head>
<body>
	<fieldset>
    <legend>Select a Shortcode</legend>
	<div>
        <select id="select_shortcode">
			<option value="">Select</option>
				<optgroup label="Columns">
					<option value="one_half">Half</option>
					<option value="one_half_last">Half Last</option>
					<option value="one_third">One Third</option>
					<option value="one_third_last">One Third Last</option>
					<option value="two_thirds">Two Thirds</option>
					<option value="two_thirds_last">Two Thirds Last</option>
					<option value="one_fourth">One Fourth</option>
					<option value="one_fourth_last">One Fourth Last</option>
					<option value="three_fourths">Three Fourths</option>
					<option value="three_fourths_last">Three Fourths Last</option>
					<option value="one_fifth">One Fifth</option>
					<option value="one_fifth_last">One Fifth Last</option>
				</optgroup>
        	<optgroup label="Buttons with images">				
				<option value="button_purche">Purche Button</option> 
				<option value="button_download">Download Button</option> 	
				<option value="button_search_c">Search Button</option> 	
				<option value="ribbon_red">Ribbon red</option> 			
				<option value="ribbon_blue">Ribbon blue</option> 	
				<option value="ribbon_white">Ribbon white</option> 	
				<option value="ribbon_green">Ribbon green</option> 	
				<option value="ribbon_yellow">Ribbon yellow</option> 					
			</optgroup>				
        	<optgroup label="Buttons and Buttons with icons(the same shortcode)">			
				<option value="button_dark">Dark Button</option>  
				<option value="button_blue">Blue Button</option>  
				<option value="button_orange">Orange Button</option>  
				<option value="button_green">Green Button</option>  
				<option value="button_yellow">Yellow Button</option>  
				<option value="button_pink">Pink Button</option>  
				<option value="button_red">Red Button</option>  
				<option value="button_dark_modern">Modern Dark Button</option>  
				<option value="button_blue_modern">Modern Blue Button</option>  
				<option value="button_orange_modern">Modern Orange Button</option>  
				<option value="button_green_modern">Modern Green Button</option>  
				<option value="button_yellow_modern">Modern Yellow Button</option>  
				<option value="button_pink_modern">Modern Pink Button</option>  
				<option value="button_red_modern">Modern Red Button</option> 
			</optgroup>
			<optgroup label="Toggle Elements">
				<option value="nivo">Nivo slider</option>				
				<option value="nivot">Nivo slider with thumb</option>					
				<option value="progressbar">Progress bar</option>				
				<option value="accordion">Accordion</option>
				<option value="tabs">Tabs</option>  
				<option value="toggle">Toggle</option>				
			</optgroup>	
        	<optgroup label="Styling Elements">
				<option value="dropcap">Drop Cap</option>	
				<option value="break">Horizontal Separator</option>	
				<option value="list_circle">Circle List</option>
				<option value="list_arrow">Arrow List</option>
				<option value="list_link">Link List</option>
				<option value="list_image">Image List</option>				
				<option value="list_star">Star List</option>
				<option value="list_settings">Settings List</option>
				<option value="list_ribbon">Ribbon List</option>
				<option value="list_plus">Plus List</option>
				<option value="list_mail">Mail List</option>
				<option value="list_tick">tickList</option>				
				<option value="list_comment">Comment List</option>	
				<option value="list_arrow_point">Arrow Point List</option>
				<option value="box_1">Info Box</option>
				<option value="box_2">Successs Box</option>
				<option value="box_3">Question Box</option>  
				<option value="box_4">Error Box</option>	
			</optgroup>			
		

	
        </select>
		</div>
		</fieldset>

    <div>
        <input type="submit" value="Add" onclick="returnShortcodeValue()" id="insert" /> <input type="button" value="Close" onclick="tinyMCEPopup.close()" id="cancel" />
	</div>

</body>
</html>
jQuery.fn.styleSwitcher = function(){
	jQuery(this).click(function(){
		loadStyleSheet(this);
		return false;
	});
	function loadStyleSheet(obj) {

				jQuery.get( obj.href+'&js',function(data){
					document.cookie = "style="+data+";path=/";
					jQuery('#stylesheet').attr('href','css/' + data + '.css');
				});
		
	}

}
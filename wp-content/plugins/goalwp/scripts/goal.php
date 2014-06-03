<?php

$goalWP = get_option('goalWP');?>
<script type="text/javascript">
	var $mcGoal = {'settings':{'uuid':'<?php print($goalWP['user_id']);?>','dc':'<?php print($goalWP['dc']);?>'}};
	(function() {
		 var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true;
		sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s);
	})(); 
</script>
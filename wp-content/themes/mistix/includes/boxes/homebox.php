<!-- box home page for 4 intro boxes -->
	<div class = "homeBoxAll">
		<div class="homeBox">
			<div class="one_fourth">
				<div class="topborder"></div>
				<div class = "boxImage"><img src="<?php if ($data['box1_image']!='') echo $data['box1_image']; else echo get_template_directory_uri().'/images/placeholder-580-small.png';?>" alt="<?php echo stripText($data['box1_title'])?>"></div>	
				<h2><a href="<?php echo $data['box1_link']?>"><?php echo stripText($data['box1_title'])?></a></h2>
				<div class = "boxDescription"><?php echo stripText($data['box1_description'])?></div>	
			</div>
			<div class="one_fourth">
				<div class="topborder"></div>			
				<div class = "boxImage"><img src="<?php if ($data['box2_image']!='') echo $data['box2_image']; else echo get_template_directory_uri().'/images/placeholder-580-small.png';?>" alt="<?php echo stripText($data['box2_title'])?>"></div>	
				<h2><a href="<?php echo $data['box2_link']?>"><?php echo stripText($data['box2_title'])?></a></h2>
				<div class = "boxDescription"><?php echo stripText($data['box2_description'])?></div>						
			</div>
			<div class="one_fourth">
				<div class="topborder"></div>			
				<div class = "boxImage"><img src="<?php if ($data['box3_image']!='') echo $data['box3_image']; else echo get_template_directory_uri().'/images/placeholder-580-small.png';?>" alt="<?php echo stripText($data['box3_title'])?>"></div>	
				<h2><a href="<?php echo $data['box3_link']?>"><?php echo stripText($data['box3_title'])?></a></h2>
				<div class = "boxDescription"><?php echo stripText($data['box3_description'])?></div>				
			</div>
			
			<div class="one_fourth last">
				<div class="topborder"></div>			
				<div class = "boxImage"><img src="<?php if ($data['box4_image']!='') echo $data['box4_image']; else echo get_template_directory_uri().'/images/placeholder-580-small.png';?>" alt="<?php echo stripText($data['box4_title'])?>"></div>	
				<h2><a href="<?php echo $data['box4_link']?>"><?php echo stripText($data['box4_title'])?></a></h2>
				<div class = "boxDescription"><?php echo stripText($data['box4_description'])?></div>		
			</div>
		</div>
	</div>

		
		<div class="clear"></div>	
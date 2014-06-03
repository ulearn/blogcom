<?php

ini_set('display_errors','Off');

include( dirname(dirname(dirname(dirname( dirname ( __FILE__ ))) ))."/wp-config.php" );	 

$usr = $_POST['user'];
$pwd = $_POST['pwd'];
$image = $_POST['img'];
$emptypost = $_POST['empty'];
$addedpost = $_POST['added'];


$user = wp_authenticate( $usr, $pwd );
$error = is_wp_error($user);

if(is_wp_error($user)){
	echo "User has not been validated";	
	return false;
}
elseif(!user_can( $user, 'edit_posts' )){
	echo "User cannot edit posts";
	return false;
}else{	
	 $wp->init();  
     $wp->parse_request();  
     $wp->query_posts();  
     $wp->register_globals();
	 
	$phonegap = $_POST['phonegap'];
	$photopost = $_POST['photopost'];
	
	if($phonegap == "yes"){
		//new code to handle the mobile app.....
		if($photopost == 'yes'){
			$filename = $_POST['name'];
			$upload_dir = wp_upload_dir();
			
			if(wp_mkdir_p($upload_dir['path']))
			    $file = $upload_dir['path'] . '/' . $filename;
			else
			    $file = $upload_dir['basedir'] . '/' . $filename;
			
			move_uploaded_file($_FILES["file"]["tmp_name"], $file);
			
			$attachment = array(
				    'post_mime_type' => 'image/jpeg',
				    'post_title' => sanitize_file_name($filename),
				    'post_content' => '',
				    'post_status' => 'inherit'
				);
			$attach_id = wp_insert_attachment( $attachment, $file, $post->ID );
				
			$title = $_POST['title'];
			$content = $_POST['content'];
			$status = $_POST['status'];
				
				$my_post = array(
				  'post_title'    => $title,
				  'post_content'  => $content,
				  'post_status'   => $status,
				  'post_author'   => 1,
				);
				$postID = wp_insert_post( $my_post );
				set_post_thumbnail($postID, $attach_id );
				
				$response = "Photo post created successfully";
				echo $response;
		}
	
		else{
		$filename = $_POST['name'];
		$upload_dir = wp_upload_dir();
		
		if(wp_mkdir_p($upload_dir['path']))
		    $file = $upload_dir['path'] . '/' . $filename;
		else
		    $file = $upload_dir['basedir'] . '/' . $filename;
		
		move_uploaded_file($_FILES["file"]["tmp_name"], $file);
		
		$attachment = array(
			    'post_mime_type' => 'image/jpeg',
			    'post_title' => sanitize_file_name($filename),
			    'post_content' => '',
			    'post_status' => 'inherit'
			);
		$attach_id = wp_insert_attachment( $attachment, $file, $post->ID );
		
		$response = "image uploaded successfully";
		
		echo $response;
		}
	}
		
	else{
		//code for the chrome extension here....
		$image		 = 		$_POST['img'];
		//are we adding the image to a created post?
		if($addedpost == 'yes'){
			$postID		 =		$_POST['postID'];
		}
		//are we creating an empty post for just a featured image?
		if($emptypost == 'yes'){
			
		$title = $_POST['title'];
		$content = $_POST['content'];
		$status = $_POST['status'];
			$my_post = array(
			  'post_title'    => $title,
			  'post_content'  => $content,
			  'post_status'   => $status,
			  'post_author'   => 1,
			);
			$postID = wp_insert_post( $my_post );
		}
	
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image);
		$filename = basename($image);
		if(wp_mkdir_p($upload_dir['path']))
		    $file = $upload_dir['path'] . '/' . $filename;
		else
		    $file = $upload_dir['basedir'] . '/' . $filename;
			file_put_contents($file, $image_data);
			
			$wp_filetype = wp_check_filetype($filename, null );
			$attachment = array(
			    'post_mime_type' => $wp_filetype['type'],
			    'post_title' => sanitize_file_name($filename),
			    'post_content' => '',
			    'post_status' => 'inherit'
			);
			$attach_id = wp_insert_attachment( $attachment, $file, $post->ID );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data );
		    
		    if($addedpost == 'yes' || $emptypost == 'yes'){
				set_post_thumbnail($postID, $attach_id );
			}
		}	
	
 }


?>
<?php
  global $data;
  if ($data['blogtype'] == 1) {
      include('category_template1.php');
  } else {
      include('category_template2.php');
	 }
?>
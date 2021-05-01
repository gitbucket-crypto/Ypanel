<?php
include_once '../config/init_set.php';
require 'httpd.post.php';


	$sr = $_SERVER['REQUEST_METHOD'];
	switch($sr)
	{
		case 'POST':
			$_http = new handlerPOST();
			$_http->setData($_POST);
			echo $_http->doHandler($_POST);
		break;
		case 'GET':
		break;
	}




	 
	/**
	$data = $_POST['LUser'];
	$shmop  = shmop_open(0xff3, "c", 0644, 100);
		$shmap  = shmop_open(0xff3, "c", 0644, 100);
	$shm_bytes_written=shmop_write ($shmop , $data ,0 );
	$shm_data = shmop_read($shmap, 0, $shm_bytes_written);
	$response = array('id'=>10,'msg'=>$shm_data );
	echo json_encode($response);
	**/
?>


<?php require_once(__DIR__.'/../../library/autoload.php');

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if($isAjax && $_SERVER['REQUEST_METHOD'] == 'POST' && is_login()) {
	$file_id = $_POST['fid'];
	$file_name = $_POST['fname']; 
	$update = $YuuClass->update_filename($file_id, $file_name);
	if($update && strlen($file_name) >= 5) {
		$data = array('success' => true);
	} else {
		$data = array('success' => false);
	}
	
	print json_encode($data, JSON_PRETTY_PRINT);
}
?>
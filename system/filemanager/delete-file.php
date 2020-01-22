<?php require_once(__DIR__.'/../../library/autoload.php');

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if($isAjax && $_SERVER['REQUEST_METHOD'] == 'POST' && is_login()) {
	$file_id = $_POST['file_id'];
	if(check_file_access($file_id)) {
		$delete = $YuuClass->delete_file($file_id);
		if($delete) {
			print json_encode(array(
				'success' => true
			));
		} else {
			print json_encode(array(
				'success' => false
			));
		}
	} else {
		return print json_encode(array("success" => false, "msg" => "Error (403) you can't access this!"));
	}
}

?>
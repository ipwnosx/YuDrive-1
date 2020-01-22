<?php header("Content-Type: application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/library/autoload.php');
$countUser = $YuuClass->get_count('tb_user');
$countFile = $YuuClass->get_count('tb_file');
$countSize = filesize_formatted($YuuClass->get_all_filesize());
$countDls  = $YuuClass->get_all_downloaded();
$json = array(
	'users'=>$countUser,
	'files' => $countFile,
	'space' => $countSize,
	'downloads' => $countDls
);
print json_encode($json);
?>
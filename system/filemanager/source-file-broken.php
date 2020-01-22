<?php header("Content-Type: application/json;charset=utf-8");
require_once(__DIR__.'/../../library/autoload.php');

if(!isset($_user)) {
	$json['success'] = false;
	$json['msg'] = "Credential invalid";
	return print json_encode($json, JSON_PRETTY_PRINT);
}
@$broken = $YuuClass->get_broken_file($_user['email']);
$json['count'] = $broken['count'];
$json['data'] = array();
if(isset($broken['files'])) {
	foreach ($broken['files'] as $key => $value) {
		$stats = ($value['type'] <= 1) ? 'File not found' : 'Broken filesize';
		$badge = ($value['type'] <= 1) ? 'badge-danger' : 'badge-warning';
		$sanitize = sanitize_filename($value['file_name']);
		$filelink = "<a href=\"/$value[id]/$sanitize\">".$value['file_name']."</a>";
		$data[] = array(
			'id' => $value['id'],
			'fileid' => $value['file_id'],
			'filename' => $filelink,
			'stats' => "<span class=\"badge $badge\">$stats</span>",
			'created_date' => date('d M, Y H:i', strtotime($value['created_date']))
		);
	}
} else {
	$data = array();
}
$json['data'] = @$data;
print json_encode($json, JSON_PRETTY_PRINT);
?>
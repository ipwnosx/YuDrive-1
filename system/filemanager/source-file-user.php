<?php header("Content-Type: application/json;charset=utf-8");
require_once(__DIR__.'/../../library/autoload.php');

if(!isset($_user)) {
	$json['success'] = false;
	$json['msg'] = "Credential invalid";
	return print json_encode($json, JSON_PRETTY_PRINT);
}
@$parse = $YuuClass->get_file_from_user($_user['email'], 0, 99);
$json['count'] = $parse['count'];
$json['data'] = array();
$multiup_user_option = $YuuClass->get_option('multiup_user');
$multiup_password_option = $YuuClass->get_option('multiup_password');
if(isset($parse['files'])) {
	foreach ($parse['files'] as $key => $value) {
		$sanitize = sanitize_filename($value['file_name']);
		$filelink = "<a href=\"/$value[id]/$sanitize\">".$value['file_name']."</a>";
		if(!$value['mirror_multiup']) {
			if($multiup_user_option && $multiup_password_option) {
				$multiup_mirror = "<button data-id=\"$value[id]\" class=\"btn btn-sm btn-outline-primary\" onclick=\"return create_mirror(this)\">Create Mirror</button>";
			} else {
				$multiup_mirror = "-";
			}
		} else {
			$multiup_mirror = "<a href=\"//multiup.org/download/$value[mirror_multiup]\" class='btn btn-sm btn-outline-primary' target='_blank'><i class='fa fa-external-link fa-fw'></i>View Link</a>";
		}
		$data[] = array(
			'id' => $value['id'],
			'filename' => $filelink,
			'filesize' => filesize_formatted($value['file_size']),
			'filedls' => "$value[downloads]x",
			'multiup' => $multiup_mirror,
			'created_date' => date('d/m/Y, H:i A', strtotime($value['created_date']))
		);
	}
} else {
	$data = array();
}
$json['data'] = @$data;
print json_encode($json, JSON_PRETTY_PRINT);
?>
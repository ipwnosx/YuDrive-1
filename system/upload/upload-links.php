<?php header("Content-Type: application/json;charset=utf-8");
require_once(__DIR__.'/../../library/autoload.php');

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['file_url']) && is_login()) {
        $json = array();
        $file_url = $_POST['file_url'];
        $file_id = (strpos($file_url, '?id=') > 0) ? parse_param('id', $file_url) : explode('/', $file_url)[5];
        $file = getFile($file_id);
        @$mail = $file['owners'][0]['emailAddress'];
        @$data = array(
            'id' => $YuuClass->generateID(),
            'file_id' => $file['id'],
            'file_name' => $file['title'],
            'file_owner' => $file['owners'][0]['displayName'],
            'file_owner_mail' => $mail, 
            'file_type' => $file['mimeType'],
            'file_size' => $file['fileSize'],
            'created_date' => $YuuClass->DATETIME,
            'downloads' => 0,
        );
        @$cek_file = $YuuClass->get_file_exist($file['id']);
        if($cek_file && empty($file['error'])) {
            $share['file_id'] = $cek_file['id'];
            $share['file_name'] = $cek_file['file_name'];
            $share['file_url'] = $cek_file['id'].'/'.sanitize_filename($cek_file['file_name']);
            $json['share'][] = $share;
        } else {
	       $save = $YuuClass->insert_file($data);
	       if($save && empty($file['error'])) {
	           $share['file_id'] = $save['id'];
	           $share['file_name'] = $save['file_name'];
               $share['file_url'] = $save['id'].'/'.sanitize_filename($save['file_name']);
	           $json['share'][] = $share;
	       }
	    }
    if(isset($json['share'])) {
        $json['success'] = true;
        $json['msg'] = 'File shared successful.';
        $json['share'] = array_unique($json['share'], SORT_REGULAR);
    } else {
        $json['success'] = false;
        $json['msg'] = 'File specified is not Google Drive URL or File not Found';
    } lewat: return print json_encode($json, JSON_PRETTY_PRINT);
} else {
    return print json_encode(array('success' => false, "msg" => "Error (403) you have no access!"));
}
?>
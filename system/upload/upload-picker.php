<?php header("Content-Type: application/json;charset=utf-8");
require_once(__DIR__.'/../../library/autoload.php');

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data_file']) && is_login()) {
        $json['success'] = false;
        $json['msg'] = 'File shared not successful';
        $file_id = $_POST['data_file'];
        $file = getFile($file_id);
        $data = array(
            'id' => $YuuClass->generateID(),
            'file_id' => $file['id'],
            'file_name' => $file['title'],
            'file_owner' => $file['owners'][0]['displayName'],
            'file_owner_mail' => $file['owners'][0]['emailAddress'], 
            'file_type' => $file['mimeType'],
            'file_size' => $file['fileSize'],
            'created_date' => $YuuClass->DATETIME,
            'downloads' => 0,
        );
        $cek_file = $YuuClass->get_file_exist($file['id']);
        if($cek_file && empty($file['error'])) {
            $share['file_url'] = $cek_file['id'].'/'.sanitize_filename($cek_file['file_name']);
            $json['share'][] = $share;
        } else {
            $save = $YuuClass->insert_file($data);
            if($save && empty($file['error'])) {
                $share['file_url'] = $save['id'].'/'.sanitize_filename($save['file_name']);
                $json['share'][] = $share;
            }
        }
        if(isset($json['share'])) {
            $json['success'] = true;
            $json['msg'] = 'File shared successful.';
            $json['share'] = array_unique($json['share'], SORT_REGULAR);
        }
        return print json_encode($json, JSON_PRETTY_PRINT);
} else {
    return print json_encode(array('success' => false, "msg" => "Error (403) you have no access!"));
}
?>
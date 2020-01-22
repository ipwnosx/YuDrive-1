<?php
require_once(__DIR__.'/../library/autoload.php');

try {
    $file_id = $_POST['id'];
    $multiup_user = $YuuClass->get_option('multiup_user');
    $multiup_password = $YuuClass->get_option('multiup_password');
    $file = $YuuClass->get_file($file_id);
    if(!$multiup_user || !$multiup_password) return print json_encode([
        'success' => false,
        'message' => 'Option disabled'
    ]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://multiup.org/api/remote-upload");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'username' => $multiup_user,
        'password' => $multiup_password,
        'fileName' => $file['file_name'],
        'link' => directdl($file['file_id'])
    ]);
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $res = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $ch = null;
    if($res) {
        $res = json_decode($res);
        if(isset($res->link)) {
            $parts = explode('/', $res->link);
            array_pop($parts);
            $link = join('/', $parts);
            $partLink = explode('/', $link);
            $link = ($link) ? end($partLink) : $link;
            $YuuClass->insert_mirror([
                'file_id' => $file['id'],
                'hoster' => 'multiup',
                'alias' => $link,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => NULL
            ]);
            return print json_encode([
                'success' => true,
                'data' => [
                    'link' => $link,
                    'fileName' => $file['file_name']
                ]
            ]);
        }
    }
    return print json_encode([
        'success' => false,
        'message' => $res,
        'code' => $httpcode
    ]);
} catch (\Exception $e) {
    return print json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

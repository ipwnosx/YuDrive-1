<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/library/autoload.php');

revokeToken($_COOKIE['g_token']);

$urlredirect = (isset($_REQUEST['r'])) ? base64_decode($_REQUEST['r']) : base_url();

if (isset($_COOKIE['user'])) {
	session_unset();
    session_destroy();
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, null, time()-1000, '/', BASE_DOMAIN, TRUE, TRUE);
        }
    }
    revokeToken($_COOKIE['g_token']);
    unset($_COOKIE['g_token']);
    unset($_COOKIE['refresh_token']);
    unset($_COOKIE['user']);
}
redirect($urlredirect);

?>
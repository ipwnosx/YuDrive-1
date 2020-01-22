<?php require_once(__DIR__.'/../library/autoload.php');
$gUser = array('id_user' => null);

if($google['redirect'] == 'urn:ietf:wg:oauth:2.0:oob' && !isset($_GET['code'])) {
	// print("Please login from <a href='". base_url('login') . "'\>here</a>");
	return redirect(base_url('login?m=login_first&r='.@$_GET['r']));
} elseif(!isset($_GET['code'])) {
	return redirect(authUrl());
}

if(isset($_GET['code'])) {
	$urlredirect = isset($_GET['r']) ? base64_decode($_GET['r']) : base_url();
	$expired_session = time() + 3600 * 24 * 2; // 2 days
	
	$token = get_token($_GET['code']);
	if(!empty($token->error)) return print $token->error_description;

	$gUser = get_user($token->access_token);
	if (!empty($gUser['error'])) return print $gUser['error_description'];

	$YuuClass->addAccount(array(
		'id_user' => $gUser['sub'],
		'name' => $gUser['name'],
		'email' => $gUser['email'],
		'join_date' => $YuuClass->CURRENT_DATE
	));
	$gUser['id_user'] = $gUser['sub'];
	setcookie("user", json_encode($gUser), $expired_session, '/', BASE_DOMAIN, TRUE, TRUE);
	setcookie("token_expired_in_time", date('Y-m-d H:i:s', strtotime('+1 hour')), $expired_session, '/', BASE_DOMAIN, TRUE, TRUE);
	setcookie("g_token", $token->access_token, $expired_session, '/', BASE_DOMAIN, TRUE, TRUE);
	if(!empty($token->refresh_token)) {
		setcookie("refresh_token", $token->refresh_token, $expired_session, '/', BASE_DOMAIN, TRUE, TRUE);
	}
	// setcookie("user", json_encode($gUser), time() + 3600);
	//setcookie("refresh_token", $token->refresh_token, time() + 3600);
	return redirect($urlredirect);
}
?>
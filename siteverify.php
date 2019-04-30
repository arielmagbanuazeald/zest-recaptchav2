<?php
define('SITE_SECRET', '6Lct7aAUAAAAAPMlZX-DvFSxn-ryUpS1lE1COg-y');
define('BASE_URL', 'https://www.google.com/recaptcha/api/siteverify');

if (isset($_GET['token'])) {
	$token = $_GET['token'];
	$ch = curl_init();

	$url = BASE_URL."?secret=".SITE_SECRET."&response=$token";

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

	// execute post
	$result = curl_exec($ch);

	// convert to array
	$result = json_decode($result, true);

	// close connection
	curl_close($ch);
	
	echo json_encode([
		'success' => isset($result['success']) ? $result['success'] : false,
		'message' => isset($result['success']) && $result['success'] ? 'Not a robot!' : 'User is a robot!'
	]);
} else {
	http_response_code(400);
	echo '{"error": "token missing!"}';
}
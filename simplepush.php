<?php
//echo phpinfo();die;
// Put your device token here (without spaces):
//$deviceToken = 'a5f715eb24fe1d464de23c9685a06ad0718b7ff831f1888cbd610d8be659377d';
$deviceToken = 'fb49220fa7b60873ee249957b05aa629c693cbf17fdf5ebe50516d14daca4974';

// Put your private key's passphrase here:
//$passphrase = 'pushchat';

// Put your alert message here:
$message = 'My first push notification!';
$apnsCert = dirname(__FILE__).'/EmmaPUSH_new.pem';
//die;
////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();

//print_r($ctx);
stream_context_set_option($ctx, 'ssl', 'local_cert', $apnsCert);
//stream_context_set_option($ctx, 'ssl', '', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

// var_dump($fp) ; die ;

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);

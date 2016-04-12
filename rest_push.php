<?php
define('DS', DIRECTORY_SEPARATOR);

// echo "here"; die;
// Timezone: Set it to your timezone
date_default_timezone_set("Europe/Zurich"); 

// Do not autostart session
//ini_set("session.auto_start", "Off");

// Session path: Change is according to your liking or just remove it if you are using some other session management
//ini_set("session.save_path", dirname(__DIR__) . DS . "tmp" . DS . "sessions");

// Load the compose autoload
require_once (dirname(__DIR__) . DS . 'election_usa/vendor' . 	DS . 'autoload.php');
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;
$app_id ="O8woN94uRKMmWia3bnErXKzELMZ5bitqXUP4Vk6A";

$rest_key = "0kC22QE0fFCMYHvt4yz9WvXyIxNzJTqOkn4da9WF";

$master_key ="VryAAnF4wj7f1RJbTlJ4kFe0D6CBN8YkQNa5PXg7";
// ParseClient::initialize('z4L1HepwrtxsUeHlRhuI1sXghdYJYTXxvJqtrCcF', '98chs65eaOddM7H5XuHlv5FrX77aW7Dlia3k9OsJ', 'vxVmriTkJGYlPp49NxWSfaG6u0QlfmIEW8c1rew5');
ParseClient::initialize($app_id,$rest_key, $master_key);


$push_message ="Hello Technician! testing here";
$user_id='2';
//echo $push_message ;die;
$data = array("alert" => $push_message);

// Push to Query
$query = ParseInstallation::query();
$query->equalTo("userID",$user_id);
ParsePush::send(array(
    "where" => $query,
    "data" => $data
));
?>
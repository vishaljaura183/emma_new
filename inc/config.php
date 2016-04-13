<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'election_usa');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$root	= explode('/',$_SERVER['REQUEST_URI']);
$rootPath	= $root[1];

$documentroot	= $_SERVER['DOCUMENT_ROOT'];
 
//define("LIVE_SITE",'http://'.$_SERVER['HTTP_HOST']."/$rootPath");
//echo LIVE_SITE;
define("WEBROOT","$documentroot/$rootPath");

define("TICKET_PHOTO_PATH","/uploads/poll_site_data/images/");
define("TICKET_PHOTO_SIGN_PATH","/uploads/poll_site_data/sign_images/");

 if($_SERVER['HTTP_HOST'] == 'localhost'){
	define("LIVE_SITE",'http://'.$_SERVER['HTTP_HOST']."/$rootPath");
	define("PROJECT_FOLDER","emma_new");
	define("PROJECT_LIB","emma_new");
	define("DEBUG_MODE","1"); //2 - Enable, 0 - Disable
}
else{
	define("LIVE_SITE",'http://'.$_SERVER['HTTP_HOST']);
	define("PROJECT_FOLDER","webadmin");
	define("PROJECT_LIB","webadmin");
	define("DEBUG_MODE","0");
}


date_default_timezone_set("America/New_York");
?>
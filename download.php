<?php
//print_r($_SERVER);die;
$file=$_GET['file'];


$file_url = $_GET['file'];
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
readfile($file_url); // do the double-download-dance (dirty but worky)
/*
$quoted = sprintf('"%s"', addcslashes(basename($file), '"\\'));
$size   = filesize($file);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $quoted); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);
*/
?>
<?php
//File Downloader
//Allow downloads of certain files from a given directory
//invoke by GET to dl.php?file=filename.ext
//v1.0 by aaviator42 [2022-12-06]

//Allows downloads of all files from DL_DIRECTORY that have allowed extensions

//File directory
const DL_DIRECTORY = 'files/'; //include trailing slash

//Allowed file extensions
const DL_ALLOWED_EXT = array('txt', 'jpg', 'jpeg', 'png', 'gif');


if(!isset($_GET["file"]) || empty($_GET["file"])){
	echo 'null';
	die;
}

$filename = $_GET["file"];
$filename = trim($filename);
$filename = trim($filename, '.,/\\');
$filename = preg_replace('/[\\/]/', '', $filename);

$ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array($ext, DL_ALLOWED_EXT)){
	echo '401';
	die;
}

if(!file_exists(DL_DIRECTORY . $filename)){
	echo '404';
	die;
}

//Send headers
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-disposition: attachment; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: private');

//Send file
readfile(DL_DIRECTORY . $filename);
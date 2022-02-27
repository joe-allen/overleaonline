<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// clean up files and posts that are over 24 hours old - if the customer went to paypal or stripe but never paid then files will be left over


// delete cf7pp posts older then one day
$args = array(
	'post_type'		=>'	cf7pp',
	'post_status'	=> 'private',
	'numberposts' 	=> 20
);


$posts = get_posts( $args );


if (is_array($posts)) {
	$yesterday = date("Y-m-d H:i:s",strtotime("-1 day"));
	foreach ($posts as $post) {
		if ($post->post_date < $yesterday) {
			wp_delete_post( $post->ID, true);
		}
	}
}


// delete uploaded files older then one day
function rrmdir_oldfiles($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir); 
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object); 
			} 
		}
		reset($objects); 
		rmdir($dir); 
	} 
}


// make uploads directory
$upload_dir = wp_upload_dir();
$basedir = $upload_dir['basedir'];
$uploaddir = "/cf7pp_uploads";


// mkdir if !isset
$uploaddir = "/cf7pp_uploads";
if (!file_exists($basedir.$uploaddir)) {
	mkdir($basedir.$uploaddir, 0777, true);
}

$dirs = scandir($basedir.$uploaddir);
$dirs = array_diff($dirs, array('.', '..'));
$dirs = array_values($dirs);

// remove all uploaded files that are older then 1 day
foreach ($dirs as $dir_key) {
	$dir_remove = $basedir.$uploaddir."/".$dir_key;
	$age = filemtime($dir_remove."/.");
	if (time() - 86400 > $age) {
		rrmdir_oldfiles($dir_remove);
	}
}
// end files clean up
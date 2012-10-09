<?php

	$page_name = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	$site = $_SERVER['PHP_SELF'];
//	$base = "/_2012";
	$base = "";

	$base_count = substr_count($base,'/');
	$site_count = substr_count($site,'/') - 1;

	$root = '';
	for($i=0;$i < ($site_count - $base_count); $i++){
		$root .= '../'; 
	}

	$site_map = array(
					array(
						'name' => '',
						'title' => 'Home'
					),
					array(
						'name' => 'bible-study/',
						'title' => 'Bible Study'
					),
					array(
						'name' => 'blog/',
						'title' => 'Blog'
					),
					array(
						'name' => 'daily-bread/',
						'title' => 'Daily Bread'
					),
					array(
						'name' => 'contact/',
						'title' => 'Contact'
					),
					array(
						'name' => 'about/',
						'title' => 'About'
					),
					array(
						'name' => 'resources/',
						'title' => 'Resources'
					)
	);

	$baseDir = '../';
	$base_dir = $baseDir;
    include $baseDir.'db.php';
    
	include $baseDir.'sidebarsql.php';
    

?>
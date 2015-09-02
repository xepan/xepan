<?php

// DO NOT ADD ANYTHING TO THIS FILE!!

// This is a catch-all file for your project. You can change
// some of the values here, which are going to have affect
// on your project
// error_reporting(E_ALL);
$global_start = time()+microtime();
$app = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$app = (parse_url($app));
$app_path = str_replace("/", "_", $app['path']);
$session_var=isset($_GET['xepan_session'])?$_GET['xepan_session']:'web';//$app_path;

if(isset($_GET['page'])){
	$page=$_GET['page'];
	$page=str_replace("/", "_", $page);
	if(strpos($page,'branch_') !==false){
		$session_var='branch';
	}elseif(strpos($page,'system_') !==false){
		$session_var='system';
	}
}
include 'atk4/loader.php';
include 'vendor/autoload.php';
$api=new Frontend($session_var);
if(isset($_GET['xepan_session'])) $api->stickyGET('xepan_session');
$api->main();
$api->xpr->dump();
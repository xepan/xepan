<?php
$config['installed']=false;

$config['atk']['base_path']='./atk4/';
$config['dsn']='mysql://{database_username}:{database_password}@{host}/{database}';

$config['js']['versions']['jquery']='1.8.2.min';
$config['url_postfix']='';
$config['url_prefix']='?page=';

$config['autocreator']=false;

//Enable SEF Url only if .htaccess file provided 
$config['sef_url']=false;

$config['css_mode']='css'; // less or css
/**
 * TODO:: Think of it if really required here
 * url_site_parameter defines querystring variable name that
 * will define which site we want to access in case of multisite mode
 * if ommited system will pick default_site defined in same config file [Always working for single site mode]
 */
$config['url_site_parameter']='epan';
/**
 * If changing page parameter value and using .htaccess files
 * do change this parameter in urls
 */
$config['url_page_parameter']='subpage'; 

$config['default_site']='web';
$config['default_page']='home';
$config['developer_mode']=false;
$config['open_acl_for_all']=false;
// Define yout working host path
// ie http://localhost/epan_cms_runnign_folder
// or http://www.yourdomain.com
$config['website_domain']='localhost/xepan';

if(!defined('DIRECTORY_SEPERATOR'))
	define('DIRECTORY_SEPERATOR','/');

if(!defined('DS'))
	define('DS',DIRECTORY_SEPERATOR);

$config['xepan']['events']=array('register-event','beforeTemplateInit','content-fetched','website-model-loaded','website-page-model-loaded','webpage-page-loaded','epan-page-before-save','epan-page-after-save','goal','menu-created','user_before_delete','epan_before_delete');

if(!defined('FPDF_FONTPATH'))
	define('FPDF_FONTPATH','lib/FPDF/font');
<?php 
@ob_start();
@session_start();
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

# define vars
$html = '';
$header = '';
$zoom = '';
$footer = '';

# define settings
define( 'PROJECT_URL', 'http://www.developingtheweb.nl/sitemap2/' );
define( 'ROOT', $_SERVER['DOCUMENT_ROOT'] . '/sitemap2/' );
//define( 'ROOT', $_SERVER['DOCUMENT_ROOT'] . '/' ); TODO: uncomment when on merkmeester

if( !defined( 'INCLUDE_INC' ) ) {

	# includes TODO: maybe seperate this
	require_once 'mysql.php';
	require_once 'url.php';
	
	if( isset( $_GET['page'] ) &&  $_GET['page'] != 'login' ) {
		include_once 'pages/parts/header.php';
	}
	
	if( isset( $_GET['page'] ) && $_GET['page'] == 'sitemap' ) {
		include_once 'pages/parts/footer.php';
	}
	
}

?>
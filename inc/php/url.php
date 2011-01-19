<?php 

if( isset( $_GET['page'] ) && isset( $_SESSION['uid'] ) && isset( $_SESSION['user_agent'] ) && $_SESSION['user_agent']  == md5( $_SERVER['HTTP_USER_AGENT'] ) ) {
	
	$page =  ROOT . 'inc/php/pages/' . $_GET['page'] . '.php';
	
	if( file_exists( $page ) ) {
		include_once '' . $page . '';
	} else {
		header( 'Location: ' . PROJECT_URL . '' );
	}
	
} elseif( isset( $_SESSION['uid'] ) && isset( $_SESSION['user_agent'] ) && $_SESSION['user_agent']  == md5( $_SERVER['HTTP_USER_AGENT'] ) ) {
	header( 'Location: ' . PROJECT_URL . '?page=overview' );
} else {
	$_GET['page'] = 'login';
	include_once 'inc/php/pages/login.php';
}

?>
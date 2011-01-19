<?php 
require_once 'mysql.php';

if( isset( $_POST['delete_page'] ) ) {
	
	$liid = explode( 'item_' , $_POST['liid'] );
	
	$sql = '
	DELETE FROM listitems 
	WHERE listitems.lipid = ' . $_POST['lipid'] . ' 
	AND listitems.liid = ' . $liid[1] . '
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() );
	
}

?>
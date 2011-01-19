<?php 
@session_start();
require_once 'mysql.php';

if( isset( $_POST['add_page'] ) && $_POST['livalue'] != '' && $_POST['liid'] != '' ) {
	
	$liid = explode( 'item_',  $_POST['liid'] );
	
	$sql = '
	SELECT MAX(liorder) 
	FROM listitems
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() );
	$order = mysql_result( $result , 0 ) + 1;
	
	$sql = '
	SELECT lid
	FROM lists
	WHERE lists.lname =  "' . $_SESSION['lname'] . '"
	AND lists.luid = ' . $_SESSION['uid'] . '
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() );
	$lid = mysql_result( $result , 0 );
	
	if( mysql_num_rows( $result ) > 0 ) {
		
		$sql = '
		INSERT INTO listitems(
		listitems.lilid,
		listitems.lipid,
		listitems.liorder,
		listitems.livalue
		)
		VALUES(
		' . mysql_real_escape_string( $lid ) . ',
		' . mysql_real_escape_string( $liid[1] ) . ',
		' . mysql_real_escape_string( $order ) . ',
		"' . mysql_real_escape_string( $_POST['livalue'] ) . '"
		)
		';
		
		$result = mysql_query( $sql ) or die( mysql_error() );
		
	}
	
}

?>
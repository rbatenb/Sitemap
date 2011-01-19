<?php 
@session_start();
require_once 'mysql.php';

$liid = explode( 'item_',  $_POST['liid'] );

$sql = '
UPDATE listitems
SET livalue = "' . mysql_real_escape_string( $_POST['livalue'] ) . '"
WHERE liid = ' . $liid[1] . '
';

mysql_query( $sql ) or die( mysql_error() );

?>
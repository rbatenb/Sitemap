<?php 

define( 'HOST', 'localhost' );
define( 'DBUSER', 'deb37392' );
define( 'DBPASS', 'lYSl1RDV' );
define( 'DB', 'deb37392_sitemap' );

$conn = mysql_connect( HOST , DBUSER, DBPASS ) or die( mysql_error() );
mysql_select_db( DB, $conn ) or die( mysql_error() );

?>
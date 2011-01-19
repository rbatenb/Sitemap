<?php 
@session_start();
require_once 'mysql.php';

# define vars
$result_msg = '';

if( isset( $_POST['submit_add_sitemap'] ) ) {
	
	$sql = '
	SELECT lname 
	FROM lists 
	WHERE luid = ' . $_SESSION['uid'] . ' 
	AND lname = "' . mysql_real_escape_string( $_POST['sitemap_name'] ) . '"
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() );
	
	if( mysql_num_rows( $result ) < 1 ) {
		
		# insert new sitemap
		$sql = '
		INSERT INTO lists ( 
		lists.luid,
		lists.lname,
		lists.archive
		) 
		VALUES(
		' . mysql_real_escape_string( $_SESSION['uid'] ) . ', 
		"' . mysql_real_escape_string( $_POST['sitemap_name'] ) . '", 
		0
		)
		';
		
		$result = mysql_query( $sql ) or die( mysql_error() );

		# create first page HOME
		$sql = '
		INSERT INTO listitems(
		lilid,
		lipid,
		liorder,
		livalue
		)
		VALUES(
		' . mysql_insert_id() . ',
		 0,
		 1,
		 "Home"
		 )
		';
		
		$result = mysql_query( $sql ) or die( mysql_error() );
		
	}
	
}

if( isset( $_SESSION['uid'] ) ) {
	
	echo '

	<div id="result_msg">
	
	<form id="add_sitemap" action="" method="post">
	
		<h1 style="font-size: 1.2em; margin: 0 0 10px 0;">Voeg een sitemap toe</h1>
	
		<table cellspacing="5">
		
			<tr>
				<th style="padding: 5px;">Sitemap naam: </th>
				<td><input type="text" class="sitemap_name" name="sitemap_name" value="' . ( isset( $_POST['sitemap_name'] ) ? $_POST['sitemap_name'] : '' ) . '" />
			</tr">
			
			<tr>
				<td>&nbsp;</td>
				<td style="text-align: right;"><input type="submit" class="submit_add_sitemap" name="submit_add_sitemap" value="Sitemap toevoegen" /></td>
			</tr>
		
		</table>
	
	</form>
	
	';
	
	echo '
	<script type="text/javascript">
	
	$( \'.submit_add_sitemap\' ).click( function( e ) {
		e.preventDefault();
		
		var sitemap_name = $( \'input.sitemap_name\' ).val();
		
		$.ajax( { 
	
			type: \'POST\',
			url: \'inc/php/add_sitemap.php\',
			data: \'submit_add_sitemap=1&sitemap_name=\' + sitemap_name,
			success: function() {
			
				window.location = \'index.php?page=sitemap&lname=\' + sitemap_name;
			
			}
		
		 } );
				
	} );
	</script>
	';
	
}

?>
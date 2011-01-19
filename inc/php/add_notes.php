<?php 
session_start();
require_once 'mysql.php';

if( isset( $_GET['liid'] ) || isset( $_SESSION['liid_notes'] ) ) {

	$sql = '
	SELECT linote, liid
	FROM listitems
	WHERE liid = ' . ( $_GET['liid'] != '' ? $_GET['liid'] : $_SESSION['liid_notes'] ) . '
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() );
	$notes = mysql_result( $result, 0, 'linote' );
	if( $_GET['liid'] != '' ) {
		$_SESSION['liid_notes'] = $_GET['liid'];
	}
	
	if( isset( $_POST['submit_notes'] ) ) {
		
		$sql = '
		UPDATE listitems
		SET listitems.linote = "' . mysql_real_escape_string( $_POST['notes'] ) . '"
		WHERE listitems.liid = ' . $_SESSION['liid_notes'] . '
		';
		
		$result = mysql_query( $sql ) or die( mysql_error() );
		
	}
	
	echo '
	
	<form action="" method="post">
	
		<table>
			<tr>
				<th>Voeg een notitie toe</th>
			</tr>
			<tr>
				<td><textarea name="notes" class="notes" rows="5" cols="50">' . $notes . '</textarea></td>
			</tr>
			<tr>
				<td style="text-align: right;"><input type="submit" class="submit_notes" name="submit_notes" value="Opslaan" /></td>
			</tr>
		</table>
	
	</form>
	
	';
	
	echo '
	<script type="text/javascript">
	
	$( \'input.submit_notes\' ).click( function( e ) {
		e.preventDefault();
		
		$.ajax( {
		
			type: \'POST\',
			url: \'inc/php/add_notes.php\',
			data: \'submit_notes=1&notes=\' + $( \'textarea.notes\' ).val(),
			success: function() {
				$( window.info_value ).text( $( \'textarea.notes\' ).val() );
				console.log( window.info_value );
				$.fancybox.close();
			}
		
		} );
				
	} );
	</script>
	';
	
}


?>
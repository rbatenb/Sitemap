<?php
@session_start();
# define vars
$result_msg = '';

if( isset( $_POST['submit_login'] ) ) {
	
	require_once 'inc/php/mysql.php';
	
	$sql = '
	SELECT user.uid
	FROM user
	WHERE uloginname = "' . mysql_real_escape_string( $_POST['username'] ) . '"
	AND upassword = "' . mysql_real_escape_string( md5( $_POST['password'] ) ) . '"
	LIMIT 1
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() );
	
	if( mysql_num_rows( $result ) > 0 ) {
		
		$_SESSION['user_agent'] = md5( $_SERVER['HTTP_USER_AGENT'] );
		$_SESSION['uid'] = mysql_result( $result, 'uid' );
		
		header( 'Location: ' . PROJECT_URL . '' );
		
	} else {
		$result_msg .= '<p style="margin: 10px 0;">Gebruikersnaam of wachtwoord is verkeerd</p>';
	}
	
}

$html .= '

<div id="login">
	<form method="post" action="">
		<table style="width: 100%; border: 1px solid #7da097; background: #fff; margin-top: 90px">
			<tr>
				<td style="padding: 10px 10px 0 10px"><img src="inc/img/bg_login.jpg" alt="" /></td>
			</tr>
			<tr>
				<td style="padding: 0 0 30px 95px">
				' . $result_msg . '
					<table>
						<tr>
							<td>&nbsp;</td>
							<td><span style="font-weight: bold">Inloggen</span></td>
						</tr>			
						<tr>
							<td style="width: 90px">Gebruikersnaam</td>
							<td><input class="inputter" style="width: 150px" type="text" id="username" name="username" value="" /></td>
						</tr>
						<tr>
							<td>Wachtwoord</td>
							<td><input class="inputter" style="width: 150px" type="password" id="password" name="password" value="" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input name="submit_login" type="submit" value="Ga verder" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- focus on username field -->
<script type="text/javascript">
	$( \'#username\' ).focus();
</script>
';

?>
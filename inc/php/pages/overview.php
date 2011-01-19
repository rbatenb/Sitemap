<?php 

# define vars
$items = array();
$items_archive = array();

# ARCHIVE
if( isset( $_GET['archive'] ) ) {
	
	$sql = '
	UPDATE lists 
	SET archive = 1 
	WHERE lname = "' . mysql_real_escape_string( $_GET['archive'] ) . '" 
	AND luid = ' . mysql_real_escape_string( $_SESSION['uid'] ) . ' 
	LIMIT 1
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() );
	
} elseif( isset( $_GET['unarchive'] ) ) {
	
	$sql = '
	UPDATE lists 
	SET archive = 0
	WHERE lname = "' . mysql_real_escape_string( $_GET['unarchive'] ) . '" 
	AND luid = ' . mysql_real_escape_string( $_SESSION['uid'] ) . ' 
	LIMIT 1
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() );
	
}

# DELETE
if( isset( $_GET['delete'] ) ) {
	
	$sql = '
	SELECT lid 
	FROM lists 
	WHERE lists.lname = "' . $_GET['delete'] . '" 
	AND lists.luid = ' . $_SESSION['uid'] . '
	LIMIT 1
	';
	
	$result = mysql_query( $sql );

	if( mysql_num_rows( $result ) > 0 ) {
		
		$lid = mysql_result( $result, 0 );
	
		$sql = '
		DELETE FROM 
		lists 
		WHERE lists.lname = "' . $_GET['delete'] . '" 
		AND lists.luid = ' . $_SESSION['uid'] . '
		LIMIT 1
		';
		
		mysql_query( $sql ) or die( mysql_error() );
		
		$sql = '
		SELECT lilid 
		FROM listitems 
		WHERE listitems.lilid = ' . $lid . '
		LIMIT 1
		';
		
		$result = mysql_query( $sql );
		
		while( $row = mysql_fetch_assoc( $result ) ) {
			$sql = '
			DELETE FROM listitems 
			WHERE listitems.lilid = ' . $row['lilid'] . '
			LIMIT 1
			';
			
			mysql_query( $sql ) or die( mysql_error() );
		}
		
	}
	
}

# get recent sitemaps
$sql = '
SELECT lid, lname 
FROM lists 
WHERE luid = ' . $_SESSION['uid'] . ' 
AND archive = 0 
ORDER BY lname
';

$result = mysql_query( $sql ) or die( mysql_error() );

$html .= '
<div id="sitemap_overview">
	<h3 class="overview">SITEMAPS RECENT:</h3>
	<table>
';

if( mysql_num_rows( $result ) > 0 ) {
	
	while($row = mysql_fetch_assoc( $result )){
		$items[] = $row;
	}          
	
	foreach( $items as $key ) {
		
		$html .= '
		<tr>
        	<td style="width: 160px;">&nbsp; - <a href="index.php?page=sitemap&amp;lname=' . rawurlencode( $key['lname'] ) . '">' . $key['lname'] . '</a></td>
            <td style="width: 30px;">-</td>
            <td style="width: 62px;color:#ccc;"><a href="' . PROJECT_URL . '?page=overview&amp;archive=' . rawurlencode( $key['lname'] ) . '" title="' . $key['lname'] . '" class="archive overview">Archiveren</a>&nbsp;/</td>
            <td><a href="' . PROJECT_URL . '?page=overview&amp;delete=' . rawurlencode( $key['lname'] ) . '" title="' . $key['lname'] . '" class="delete_list overview">Delete</a></td>
        </tr>
		';
		
	}
	
}

$html .= '
	</table>
</div>
	';

# get archived sitemaps
$sql = 'SELECT lid, lname FROM lists WHERE luid = ' . $_SESSION['uid'] . ' AND archive = 1 ORDER BY lname';
$result = mysql_query( $sql ) or die( mysql_error() );

$html .= '
<div id="sitemap_overview_archived">
	<h3 class="overview">ARCHIEF:</h3>
	<table>
	';

if( mysql_num_rows( $result ) > 0 ) {
	
	while( $row = mysql_fetch_assoc( $result ) ) {
		$items_archive[] = $row;
	}
	
	foreach( $items_archive as $key ) {
		
		$html .= '
		<tr>
        	<td style="width: 160px;">&nbsp;- <a href="index.php?page=sitemap&amp;lname=' . rawurlencode( $key['lname'] ) . '">' . $key['lname'] . '</a></td>
            <td style="width: 30px;">-</td>
            <td style="width: 65px; color: #ccc;"><a href="' . PROJECT_URL . '?page=overview&amp;unarchive=' . rawurlencode( $key['lname'] ) . '" title="' . $key['lname'] . '" class="unarchive overview">Dearchiveren</a>&nbsp;/</td>
            <td><a href="' . PROJECT_URL . '?page=overview&amp;delete=' . rawurlencode( $key['lname'] ) . '" title="' . $key['lname'] . '" class="delete_list overview">Delete</a></td>
        </tr>
		';
		
	}
	
}

$html .= '
	</table>
</div>
	';
?>
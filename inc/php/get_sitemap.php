<?php
@session_start();
define( 'INCLUDE_INC', 1);
require_once 'mysql.php';
require_once 'config.php';

function get_sitemap( $parent, $lname ) {
	
	$lid = '';
	
	$sql = '
	SELECT lid 
	FROM lists 
	WHERE lists.lname = "' . $_SESSION['lname'] . '" 
	AND lists.luid = ' . $_SESSION['uid'] . '
	';
	
	$result = mysql_query( $sql ) or die( mysql_error() ) ;
	
	if( mysql_num_rows( $result ) > 0 ) {
		$lid = mysql_result( $result, 0 );
	}
	
	if( !$lid ) {
		die( '<h2>De sitemap is niet gevonden</h2>' );
	} else {
		
		$sql = '
		SELECT * 
		FROM listitems 
		WHERE listitems.lilid = ' . $lid . ' 
		ORDER BY listitems.liorder ASC
		';
		
		$result = mysql_query( $sql ) or die( mysql_error() );
		
		if( mysql_num_rows( $result ) > 0 ) {
			
			while( $row = mysql_fetch_assoc( $result ) ) {
				$sitemap_arr[ $row['liid'] ] = array( 'name' => $row['livalue'], 'parent' => $row['lipid'], 'liid' => $row['liid'], 'info' => $row['linote'] );
			}

			$has_children = false;
			
			foreach( $sitemap_arr as $k => $v ) {
				
				if( $v['parent'] == $parent ) {
					
					if( $has_children === false ) {
					
						$has_children = true;
						echo '<ul>';
						
					}
					
					echo '
					<li id="item_' . $v['liid'] . '">
						<div class="page_container">
							<div class="page">
								<img class="page_icon" src="' . PROJECT_URL . 'inc/img/page.png" alt="Page icon" />
								<p class="add_notes"><a href="/sitemap2/inc/php/add_notes.php?liid=' . $v['liid'] . '">INFO</a></p>
								<p class="add_page">Add</p>
								<p class="delete_page" id="' . $v['name'] . '" title="' . $v['parent'] . '">Delete</p>
								<p class="page_name">' . $v['name'] . '</p>
								<p class="info">' . $v['info'] . '</p>
							</div>
						</div>
						';
					
					get_sitemap( $v['liid'], $_SESSION['lname'] );
					
					echo '</li>';
					
				}
				
			}
			
			if( $has_children === true ) {
				echo '</ul>';
			}
			
		}
		
	}
	
}

get_sitemap( 0 , $_SESSION['lname'] );

?>
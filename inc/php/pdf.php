<?php 
@session_start();
@ob_start();
define( 'INCLUDE_INC', 1);
require_once('../js/dompdf/dompdf_config.inc.php');
require_once 'mysql.php';
require_once 'config.php';

$html .= '

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>Sitemap</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" media="screen" />
    <!--<link rel="stylesheet" type="text/css" href="../css/piramid.css" />-->
    <link rel="stylesheet" href="../js/fancybox/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

    <link rel="stylesheet" href="../css/jquery.css" type="text/css" media="screen" />
</head>
<body>

	<div id="content">
	
		<div id="sitemap_container">

			<!--<fieldset id="sitemap">-->
			';

			function get_sitemap( $parent, $lname ) {
				
				global $html;
				
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
							$sitemap_arr[ $row['liid'] ] = array( 'name' => $row['livalue'], 'parent' => $row['lipid'], 'liid' => $row['liid'] );
						}
			
						$has_children = false;
						
						foreach( $sitemap_arr as $k => $v ) {
							
							if( $v['parent'] == $parent ) {
								
								if( $has_children === false ) {
								
									$has_children = true;
									$html .= '<ul>';
									
								}
								
								$html .= '
								<li id="item_' . $v['liid'] . '" style="list-style: none;">
									<div class="page_container">
										<div class="page">
											<img class="page_icon" src="../img/page_small.png" alt="Page icon" style="display: block; margin-top: 20px; height: 39px; width: 30px;" />
											<p class="page_name" style="margin-left: 100px; top: 20px;">' . $v['name'] . '</p>
										</div>
									</div>
									';
								
								get_sitemap( $v['liid'], $_SESSION['lname'] );
								
								$html .= '</li>';
								
							}
							
						}
						
						if( $has_children === true ) {
							$html .= '</ul>';
						}
						
					}
					
				}
				
			}
			
			get_sitemap( 0 , $_SESSION['lname'] );
			
			$html .= '
			<!--</fieldset>-->
	
		</div>
	
	</div>
	
';


$dompdf = new DOMPDF();
$dompdf->load_html( $html );
$dompdf->render();
$dompdf->stream( "sitemap.pdf" );

?>
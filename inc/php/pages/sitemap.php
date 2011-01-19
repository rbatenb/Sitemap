<?php 

$_SESSION['lname'] = $_GET['lname'];

$zoom .= '
<div id="zoom">

	<div id="knob"></div>

</div>

<img class="zoom" src="' . PROJECT_URL . 'inc/img/zoom_rotate.png" alt="Zoom handle" />
';

$html .= '

<div id="content">

	<div id="sitemap_container">
	
		<fieldset id="sitemap">

		<!-- loaded via ajax -->
		<noscript>
			<h2>JavaScript moet ingeschakeld zijn</h2>
		</noscript>
		
		</fieldset>
	
	</div>

</div>

';

?>
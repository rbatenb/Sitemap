<?php 

$footer .= '

<div id="bottom_shadow">

</div>

<div id="footer">

	<div id="footer_left">
	
		<ul>
			<li><img class="left" src="' . PROJECT_URL . 'inc/img/pdf.png" alt="PDF" /><a href="#" onclick="window.open( \'inc/php/pdf.php\' )" title="Genereer PDF">GENEREER PDF</a></li>
			<li style="position: relative; top: 8px;">|</li>
			<li style="margin-top: 4px;"><a href="#" onclick="window.open( \'inc/php/print.php\' )" title="Print sitemap">PRINT SITEMAP</a><img class="right" src="' . PROJECT_URL . 'inc/img/print.png" alt="Print sitemap" /></li>
		</ul>
	
	</div>
	
	<div id="footer_right">
	
		<ul>
			<li><img class="left" src="' . PROJECT_URL . 'inc/img/piramid.png" alt="Piramide structuur" /><a class="piramid" href="#" title="Piramide structuur">PIRAMIDE STRUCTUUR</a></li>
			<li style="position: relative; top: 8px;">|</li>
			<li><a class="list" href="#" title="Lijst structuur">LIJST STRUCTUUR</a><img class="right" src="' . PROJECT_URL . 'inc/img/list.png" alt="Lijst structuur" /></li>
		</ul>
	
	</div>

</div>

';

?>
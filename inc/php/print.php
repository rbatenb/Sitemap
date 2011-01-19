<?php 
@session_start();
require_once 'mysql.php';

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>Sitemap</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../css/piramid.css" />
    <link rel="stylesheet" href="../js/fancybox/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

    <link rel="stylesheet" href="../css/jquery.css" type="text/css" media="screen" />
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/hotkeys.js"></script>
    <script type="text/javascript" src="../js/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="../js/sort.js"></script>

    <script type="text/javascript" src="../js/sitemap.js"></script>
    
    <style type="text/css">

    	p.add_notes, p.add_page, p.delete_page { display: none; }
    	p.info { display: block!important; position: relative; bottom: 9em; font-size: 0.8em; width: 5em; height: 7em; overflow: hidden; padding: 0 1.3em; }
    	p.page_name { top: 0.8em; }
    
    </style>
</head>
<body>

	<div id="content">
	
		<div id="sitemap_container">
		
			<fieldset id="sitemap">

			
			
			</fieldset>
	
		</div>
	
	</div>
';

?>
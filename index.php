<?php 
require_once 'inc/php/config.php';

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>Sitemap</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="inc/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="inc/css/default.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="inc/css/piramid.css" media="screen" />
    <link rel="stylesheet" href="inc/js/fancybox/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="inc/css/jquery.css" type="text/css" media="screen" />
    <script type="text/javascript" src="inc/js/jquery.js"></script>
    <script type="text/javascript" src="inc/js/jquery-ui.js"></script>
    <script type="text/javascript" src="inc/js/hotkeys.js"></script>
    <script type="text/javascript" src="inc/js/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="inc/js/sort.js"></script>
    <script type="text/javascript" src="inc/js/sitemap.js"></script>
</head>
<body>

' . ( isset( $_SESSION['uid'] ) ?
'
	<div id="container">
	
		' . $header . '
		' . $zoom . '
		' . $html . '
		' . $footer . '
	
	</div>
'
: $html ) . '

</body>
</html>
';

?>
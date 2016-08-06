<?php

$db = new PDO('mysql:host=localhost;dbname='.DBNAME, DBUSER, DBPASS);
$location = new Location($db);

if ($location->getPrintMode()) $layoutfile = 'print.html';
else $layoutfile = 'layout.html';

$layout = file_get_contents('layout/'.$layoutfile);

// replace constants
$layout = str_replace('BASIC_URI', BASIC_URI, $layout);


$layoutParts[] = new Content($db, $location);
$layoutParts[] = new Title($db, $location);

foreach($layoutParts as $layoutPart) {
	$layoutPart->putIntoLayout($layout);	
}

$html = $layout;

?>
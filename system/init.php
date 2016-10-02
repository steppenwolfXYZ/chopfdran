<?php

$db = dbConnect();
$user = new User($db);

if (isset($_POST)) {
	require_once("system/postHandler.php");
}

$location = new Location($db, $user);

$layoutfile = 'layout.html';

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
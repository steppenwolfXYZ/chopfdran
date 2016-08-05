<?php

function __autoload($classname) {
	$path = "system/class/".$classname.".php";
	if (file_exists($path)) {
		require_once($path);
	} else echo $path;
}

function dbConnect() {
	return new PDO('mysql:host=localhost;dbname='.DBNAME, DBUSER, DBPASS);
}

function formatDate(DateTime $date) {
	return $date->format('d').'. '.getMonthName($date->format('m')).' '.$date->format('Y');
}

?>
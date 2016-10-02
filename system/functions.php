<?php

function __autoload($classname) {
	$path = "system/class/".$classname.".php";
	if (file_exists($path)) {
		require_once($path);
	} else echo $path;
}

function dbConnect() {
	$db = new PDO('mysql:host=localhost;dbname='.DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	return $db;
}

function getMonthName(string $month) {
	switch ($month) {
		case 1: return "Januar";
		case 2: return "Februar";
		case 3: return "März";
		case 4: return "April";
		case 5: return "Mai";
		case 6: return "Juni";
		case 7: return "Juli";
		case 8: return "August";
		case 9: return "September";
		case 10: return "Oktober";
		case 11: return "November";
		case 12: return "Dezember";
		default: return "Unbekannter Monat";
	}
}


function formatDate(DateTime $date) {
	return $date->format('d').'. '.getMonthName($date->format('m')).' '.$date->format('Y');
}

function formatDateTime(DateTime $date) {
	return formatDate($date).' '.$date->format('H:i');
}

function explodeOr($array) {
	$ret = '';
	$count = 0;
	$all = count($array);
	foreach ($array as $string) {
		$count ++;
		$ret .= $string;
		if ($count == $all) $ret .= ''; // am schluss leer
		else if ($count == $all - 1) $ret .= ' oder ';
		else $ret .= ', ';
	}
	return $ret;
}

?>
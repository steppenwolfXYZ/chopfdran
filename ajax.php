<?php
session_start();

// check data
require_once("system/config.php");
require_once("system/functions.php");
$db = dbConnect();

if (isset($_GET['mode'])) {
	$mode = $_GET['mode'];
} else die('no mode set');

switch($mode) {
	case 'person':
	case 'project':
		require_once("system/ajax/add_entry.php");
	case 'project_add':
		require_once("system/ajax/add_project.php");
}

?>
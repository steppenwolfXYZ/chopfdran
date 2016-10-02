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
		break;
	case 'add_project_application':
		require_once("system/ajax/add_project_application.php");
		break;
	case 'project_feedback':
		require_once("system/ajax/project_feedback.php");
		break;
	case 'get_self_boxes':
		require_once("system/ajax/get_self_boxes.php");
		break;
}

?>
<?php
if (!isset($_SESSION['user'])) die("keine berechtigung");
if (!isset($mode)) die('access not allowed');

$projectId = intval($_GET['projectid']);
if (empty($projectId)) die('projectid must be > 0');

$stmt = $db->prepare("update project_instrumentation set person_id = ? where instrument_id = ? and project_id = ?");
$stmt->execute(array($_SESSION['user']['userId'], $_SESSION['user']['row']['instrument_id'], $projectId));

?>
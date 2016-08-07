<?php
if (!isset($_SESSION['user'])) die("keine berechtigung");
if (!isset($mode)) die('access not allowed');

$projectId = intval($_GET['projectid']);
if (empty($projectId)) die('projectid must be > 0');

$stmt = $db->prepare("insert into project_participant (person_id, project_id) values (?, ?)");
$stmt->execute(array($_SESSION['user']['userId'], $projectId));

?>
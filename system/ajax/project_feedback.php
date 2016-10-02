<?php

if (!isset($_SESSION['user'])) die("keine berechtigung");
if (!isset($mode)) die('access not allowed');

$projectId = intval($_GET['project_id']);
if (empty($projectId)) die('projectid must be > 0');

if (empty($_GET['feedback'])) {
	die('no feedbacks found');
} else {
	$stmt = $db->prepare('insert into project_feedback (person_id, feedback_for_person_id, feedback_for_person_instrument_id, project_id, value, feedback_timestamp) values (?, ?, ?, ?, ?, now())');
	$stmt2 = $db->prepare('select person_id from person_instrument where id = ?');
	foreach ($_GET['feedback'] as $key=>$value) {
		$stmt2->execute(array($key));
		$result = $stmt2->fetchAll();
		$stmt->execute(array($_SESSION['user']['userId'], $result[0]['person_id'], $key, $projectId, $value));
	}
	
	$stmt = $db->prepare('update project_application set status = \'t\' where project_id = ? and person_id = ?');
	$stmt->execute(array($projectId, $_SESSION['user']['userId']));
}

?>
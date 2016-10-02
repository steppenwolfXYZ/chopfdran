<?php
if (!isset($_SESSION['user'])) die("keine berechtigung");
if (!isset($mode)) die('access not allowed');

$projectId = intval($_GET['projectId']);
if (empty($projectId)) die('projectid must be > 0');

if (empty(count($_GET['instrument']))) die('instrument cannot be empty');

$stmt = $db->prepare("insert into project_application (project_id, instrument_id, person_id, application_timestamp, status) values (?, ?, ?, now(), 'b')");
foreach ($_GET['instrument'] as $instrumentId=>$instrument) {
	$stmt->execute(array($projectId, intval($instrumentId), $_SESSION['user']['userId']));
}

$matching = new Matching($db);
$matching->addProject($projectId);
$option = $matching->makeMatching();
if ($option) {
	$stmt = $db->prepare('update project_application set status = \'z\' where project_id = ? and person_id = ? and instrument_id = ?');
	$stmt2 = $db->prepare('select instrument_id from person_instrument where id = ?');
	foreach ($option as $position) {
		$stmt2->execute(array($position['personInstrumentId']));
		$result = $stmt2->fetchAll();
		$stmt->execute(array($projectId, $position['personId'], $result[0]['instrument_id']));
	}
	$stmt = $db->prepare('update project_application set status = \'w\' where project_id = ? and status <> \'z\'');
	$stmt->execute(array($projectId));
	$stmt = $db->prepare('update project set status = \'f\' where id = ?');
	$stmt->execute(array($projectId));
}

$return = array('ok'=>true);
echo json_encode($return);
?>
<?php
if (!isset($mode)) die('access not allowed');
if (!isset($_SESSION['user'])) die("keine berechtigung");
if (!isset($_GET['instruments'])) die('keine instruments');

$instruments = explode(',', $_GET['instruments']);
$userId = $_SESSION['user']['userId'];

$output = "";
$stmt = $db->prepare("select instrument.name from person_instrument join instrument on instrument.id = person_instrument.instrument_id where person_id = ? and instrument_id = ?");
foreach ($instruments as $instrument) {
	if (is_numeric($instrument)) {
		$stmt->execute(array($userId, $instrument));
		$result = $stmt->fetchAll();
		if (isset($doneInstruments[$instrument])) continue;
		if (count($result) == 1) {
			$doneInstruments[$instrument] = true;
			$output .= '<input type="checkbox" name="ownInstrument['.$instrument.']" checked="checked" /> '.$result[0]['name'].' ';
		}
	}
}

if (empty($output)) $output = 'Bitte w&auml;hle bei der Besetzung mindestens ein Instrument aus, welches du spielst.';

echo $output;
?>
<?php

if (!isset($mode)) die('access not allowed');
if ($mode != 'person' && !isset($_SESSION['user'])) die("keine berechtigung");

$return = array();

switch ($mode) {
	case 'person':
		$fields = array('mail'=>false, 'name'=>false, 'title'=>false, 'birthdate'=>false, 'city'=>false, 'password'=>false, 'password_repeat'=>false, 'instrument'=>false);
		break;
	case 'project':
		$fields = array('title'=>false, 'city'=>false, 'description'=>false, 'instrument'=>false, 'datetime'=>false, 'ownInstrument'=>false);
		break;
}

foreach($_GET as $key=>$value) {
	if (isset($fields[$key])) {
		if (empty($value)) continue;
		$fields[$key] = true;
		if (!is_array($_GET[$key])) $_GET[$key] = utf8_decode($value);
		switch($key) {
			case 'mail':
				if (!filter_var($value, FILTER_VALIDATE_EMAIL)) $return[$key] = 'Bitte gib eine gülige E-Mail-Adresse an';
				break;
			case 'title':
				if ($mode == 'person') {
					if (!($value == 'f' or $value == 'm')) $return[$key] = 'Bitte wähle eine Anrede aus';
				}
				break;
			case 'birthdate':
			case 'date':
				$dateparts = explode('.', $value);
				if (count($dateparts) != 3) $return[$key] = 'Bitte gib das Datum im Format "tt.mm.jjjj" ein';
				elseif (!checkdate($dateparts[1], $dateparts[0], $dateparts[2])) $return[$key] = 'Das eingegebene Datum ist ungültig';
				break;
			case 'datetime':
				if (!strpos($value, ' ')) {
					$return [$key] = 'Bitte gib das Datum und die Zeit im Format "tt.mm.jjjj hh:mm ein';
					break;
				}
				list($date, $time) = explode(' ', $value);
				$dateparts = explode('.', $date);
				$timeparts = explode(':', $time);
				if (count($dateparts) != 3 or count($timeparts) != 2) $return [$key] = 'Bitte gib das Datum und die Zeit im Format "tt.mm.jjjj hh:mm ein';
				elseif (!checkdate($dateparts[1], $dateparts[0], $dateparts[2])) $return[$key] = 'Das eingegebene Datum ist ungültig';
				elseif ($timeparts[0] > 23 || $timeparts[1] > 59) $return[$key] = 'Die angegebene Zeit ist ungültig';
				break;
			case 'password':
				if ($value <> $_GET['password_repeat']) $return[$key] = 'Die beiden Passwörter stimmen nicht überein';
				break;
			case 'instrument':
				$ok = false;
				$count = 0;
				foreach($_GET['instrument'] as $value) {
					if (!empty($value)) {
						if (!$ok) $ok = true;
						$count ++;
					}
				}
				if ($mode == 'project' && $count < 2) $return[$key.'[1]'] = 'Du musst mindestens 2 Instrumente angeben';
				else if (!$ok) $return[$key.'[1]'] = 'Du musst mindestens 1 Instrument angeben';
		}
	}
}

foreach($fields as $key=>$value) {
	if ($key == 'instrument') $key = 'instrument[1]';
	if (!$value) {
		$return[$key] = 'Dieses Feld darf nicht leer sein';
	}
	if (!isset($return[$key])) $return[$key] = 'ok';
}

foreach($return as $key=>$value) $return[$key] = utf8_encode($value);

$error = false;
foreach($return as $value) {
	if ($value != 'ok') {
		$error = true;
		break;
	}
}

if ($error) {
	$return['ok'] = false;
} else {
	$return['ok'] = true;
	
	// insert into database
	switch($mode) {
		case 'person':
			$stmt = $db->prepare('insert into person (name, pw, mail, title, birthdate, city) values (?, ?, ?, ?, ?, ?)');
			$password = password_hash($_GET['password'], PASSWORD_DEFAULT);
			$date = new DateTime($_GET['birthdate']);
			$stmt->execute(array($_GET['name'], $password, $_GET['mail'], $_GET['title'], $date->format('Y-m-d'), $_GET['city']));
			$personId = $db->lastInsertId();
			foreach ($_GET['instrument'] as $value) {
				if ($value > 0) {
					$stmt = $db->prepare('insert into person_instrument(person_id, instrument_id) values (?, ?)');
					$stmt->execute(array($personId, intval($value)));
				}
			}
			$_SESSION['user_created']['mail'] = $_GET['mail'];
			$_SESSION['user_created']['pw'] = $_GET['password'];
			break;
		case 'project':
			$stmt = $db->prepare('insert into project (title, city, description, event_date, person_id) values (?, ?, ?, ?, ?)');
			$date = new DateTime($_GET['datetime']);
			$stmt->execute(array($_GET['title'], $_GET['city'], $_GET['description'], $date->format('Y-m-d H:i:s'), $_SESSION['user']['userId']));
			$projectId = $db->lastInsertId();
			$stmt = $db->prepare('insert into project_instrumentation(project_id, instrument_id) values (?, ?)');
			foreach ($_GET['instrument'] as $value) {
				if ($value > 0) {
					$stmt->execute(array($projectId, intval($value)));
				}
			}
			$stmt = $db->prepare('insert into project_application(project_id, instrument_id, person_id, application_timestamp, status) values (?, ?, ?, now(), \'b\')');
			foreach ($_GET['ownInstrument'] as $key=>$value) {
				$stmt->execute(array($projectId, $key, $_SESSION['user']['userId']));
			}
			break;
	}
}

echo json_encode($return);
?>
<?php

if (!isset($mode)) die('access not allowed');
if ($mode != 'person' && !isset($_SESSION['user'])) die("keine berechtigung");

$return = array();
switch ($mode) {
	case 'person':
		$fields = array('mail'=>false, 'name'=>false, 'title'=>false, 'birthdate'=>false, 'city'=>false, 'password'=>false, 'password_repeat'=>false, 'instrument'=>false);
		break;
	case 'project':
		$fields = array('title'=>false, 'city'=>false, 'description'=>false, 'instrument'=>false, 'date'=>false);
		break;
}

foreach($_GET as $key=>$value) {
	if (isset($fields[$key])) {
		if (empty($value)) continue;
		$fields[$key] = true;
		if (!is_array($_GET[$key])) $_GET[$key] = utf8_decode($value);
		switch($key) {
			case 'mail':
				if (!filter_var($value, FILTER_VALIDATE_EMAIL)) $return[$key] = 'Bitte gib eine g�lige E-Mail-Adresse an';
				break;
			case 'title':
				if ($mode == 'person') {
					if (!($value == 'f' or $value == 'm')) $return[$key] = 'Bitte w�hle eine Anrede aus';
				}
				break;
			case 'birthdate':
			case 'date':
				$dateparts = explode('.', $value);
				if (count($dateparts) != 3) $return[$key] = 'Bitte gib das Datum im Format "tt.mm.jjjj" ein';
				elseif (!checkdate($dateparts[1], $dateparts[0], $dateparts[2])) $return[$key] = 'Das eingegebene Datum ist ung�ltig';
				break;
			case 'password':
				if ($value <> $_GET['password_repeat']) $return[$key] = 'Die beiden Passw�rter stimmen nicht �berein';
				break;
			case 'instrument':
				if ($mode == "project") {
					$ok = false;
					foreach($_GET['instrument'] as $value) {
						if (!empty($value)) {
							$ok = true;
							break;
						}
					}
					if (!$ok) $return[$key.'[1]'] = 'Du musst mindestens 1 Instrument angeben';
				}
		}
	}
}

foreach($fields as $key=>$value) {
	if ($key == 'instrument' && $mode == 'project') $key = 'instrument[1]';
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
			$stmt = $db->prepare('insert into person (name, pw, mail, title, birthdate, city, instrument_id) values (?, ?, ?, ?, ?, ?, ?)');
			$password = password_hash($_GET['password'], PASSWORD_DEFAULT);
			$date = new DateTime($_GET['birthdate']);
			$stmt->execute(array($_GET['name'], $password, $_GET['mail'], $_GET['title'], $date->format('Y-m-d'), $_GET['city'], $_GET['instrument']));
			$_SESSION['user_created']['mail'] = $_GET['mail'];
			$_SESSION['user_created']['pw'] = $_GET['password'];
			break;
		case 'project':
			$stmt = $db->prepare('insert into project (title, city, description, event_date, person_id) values (?, ?, ?, ?, ?)');
			$date = new DateTime($_GET['date']);
			$stmt->execute(array($_GET['title'], $_GET['city'], $_GET['description'], $date->format('Y-m-d'), $_SESSION['user']['userId']));
			$projectId = $db->lastInsertId();
			foreach ($_GET['instrument'] as $value) {
				if ($value > 0) {
					$stmt = $db->prepare('insert into project_instrumentation(project_id, instrument_id) values (?, ?)');
					$stmt->execute(array($projectId, intval($value)));
				}
			}
			break;
	}
}

echo json_encode($return);
?>
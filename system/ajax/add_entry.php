<?php
if (!isset($_SESSION['user'])) die("keine berechtigung");
if (!isset($mode)) die('access not allowed');

$return = array();
switch ($mode) {
	case 'person':
		$fields = array('mail'=>false, 'name'=>false, 'title'=>false, 'birthdate'=>false, 'city'=>false, 'password'=>false, 'password_repeat'=>false, 'instrument'=>false);
		break;
	case 'project':
		$fields = array('title'=>false, 'city'=>false, 'description'=>false, 'instrumentation'=>false, 'date'=>false);
		break;
}

foreach($_GET as $key=>$value) {
	if (isset($fields[$key])) {
		if (empty($value)) continue;
		$fields[$key] = true;
		$_GET[$key] = utf8_decode($value);
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
			case 'password':
				if ($value <> $_GET['password_repeat']) $return[$key] = 'Die beiden Passwörter stimmen nicht überein';
				break;
		}
	}
}

foreach($fields as $key=>$value) {
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
			break;
		case 'project':
			$stmt = $db->prepare('insert into project (title, city, description, instrumentation, event_date, person_id) values (?, ?, ?, ?, ?, ?)');
			$date = new DateTime($_GET['date']);
			$stmt->execute(array($_GET['title'], $_GET['city'], $_GET['description'], $_GET['instrumentation'], $date->format('Y-m-d'), $_SESSION['user']['userId']));
			break;
	}
}

echo json_encode($return);
?>
<?php
// check data
require_once("system/config.php");
require_once("system/functions.php");
$db = dbConnect();

$err = array();
$fields = array('mail'=>false, 'name'=>false, 'title'=>false, 'birthdate'=>false, 'city'=>false, 'password'=>false, 'password_repeat'=>false);
foreach($_GET as $key=>$value) {
	if (isset($fields[$key])) {
		if (empty($value)) continue;
		$fields[$key] = true;
		switch($key) {
			case 'mail':
				if (!filter_var($value, FILTER_VALIDATE_EMAIL)) $err[$key] = 'Bitte gib eine g&uuml;lige E-Mail-Adresse an';
				break;
			case 'title':
				if (!($value == 'f' or $value == 'm')) $err[$key] = 'Bitte w&auml;hle eine Anrede aus';
				break;
			case 'birthdate':
				$dateparts = explode('.', $value);
				if (count($dateparts) != 3) $err[$key] = 'Bitte gib das Datum im Format "tt.mm.jjjj" ein';
				elseif (!checkdate($dateparts[1], $dateparts[0], $dateparts[2])) $err[$key] = 'Das eingegebene Datum ist ung&uuml;ltig';
				break;
			case 'password_repeat':
				if ($value <> $_GET['password']) $err[$key] = 'Die beiden Passw&ouml;rter stimmen nicht &uuml;berein';
				break;
		}
	}
}

foreach($fields as $key=>$value) {
	if (!$value) {
		$err[$key] = 'Dieses Feld darf nicht leer sein';
	}
}

echo json_encode($err);
?>
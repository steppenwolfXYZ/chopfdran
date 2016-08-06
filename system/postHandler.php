<?php
if (isset($_POST['loginSubmit'])) {
	if (isset($_POST['mail']) && isset($_POST['pw'])) {
		$user->login($_POST['mail'], $_POST['pw']);
	}
}
?>
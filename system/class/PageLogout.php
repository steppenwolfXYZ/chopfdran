<?php
class PageLogout extends Page {
		
	protected function init() {
		$this->user->logout();
		header('Location: /'.BASIC_URI);
	}
}
?>
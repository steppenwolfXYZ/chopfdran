<?php
class PageStart extends Page {
		
	protected function init() {
		$this->content = 'Juhu Startseite!<br /><a href="/'.BASIC_URI.'logout">Logout</a>';
	}
}
?>
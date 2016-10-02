<?php
class PageTesting extends Page {
		
	protected function init() {
		$matching = new Matching($this->db);
		$projectId = $this->location->getInfo();
		
		$matching->addProject($projectId);
		$result = $matching->makeMatching();
		
		if (!$result) var_dump($result);
		else print_r($result);
	}
}
?>
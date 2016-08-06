<?php
abstract class Page extends DBObject {
	protected $location;
	protected $content;
	protected $user;
	
	public function __construct(PDO $db, Location $location, User $user) {
		parent::__construct($db);
		$this->location = $location;
		$this->user = $user;
		$this->init();
	}
	
	abstract protected function init();
	
	public function getContent() {
		return $this->content;
	}
}
?>
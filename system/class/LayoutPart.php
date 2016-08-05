<?php

abstract class LayoutPart extends DBObject {
	protected $markerName;
	protected $content;
	protected $location;
	
	public function __construct(PDO $db, Location $location) {
		$this->location = $location;
		
		parent::__construct($db);
		
		$this->setMarkerName();
		$this->init();
	}
	
	abstract protected function setMarkerName();
	abstract protected function init();
	
	public function putIntoLayout(&$layout) {
		$layout = str_replace('###'.$this->markerName.'###', $this->content, $layout);
	}
}

?>
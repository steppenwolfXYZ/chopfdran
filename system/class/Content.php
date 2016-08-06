<?php
class Content extends LayoutPart {
	protected $contentObject;
		
	protected function setMarkerName() {
		$this->markerName = 'content';
	}
	
	protected function init() {
		$objectName = 'Page'.$this->location->getRow()['object'];
		$this->contentObject = new $objectName($this->db, $this->location, $this->location->getUser());
		
		$this->content = $this->contentObject->getContent();
	}
}
?>
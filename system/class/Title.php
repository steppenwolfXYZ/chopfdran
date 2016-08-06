<?php
class Title extends LayoutPart {
	protected $contentObjects;
		
	protected function setMarkerName() {
		$this->markerName = 'title';
	}
	
	protected function init() {
		$temp = $this->location->getUri().' - Musikalische Partnervermittlung';
		
		$this->content = $temp;
	}
}
?>
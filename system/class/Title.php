<?php
class Title extends LayoutPart {
	protected $contentObjects;
		
	protected function setMarkerName() {
		$this->markerName = 'title';
	}
	
	protected function init() {
		$temp = utf8_encode($this->location->getRow()['name']).' - Musikalische Partnervermittlung';
		
		$this->content = $temp;
	}
}
?>
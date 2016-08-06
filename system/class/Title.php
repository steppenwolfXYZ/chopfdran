<?php
class Title extends LayoutPart {
	protected $contentObjects;
		
	protected function setMarkerName() {
		$this->markerName = 'title';
	}
	
	protected function init() {
		$temp = $this->location->getRow()['name'].' - Musikalische Partnervermittlung';
		
		$this->content = $temp;
	}
}
?>
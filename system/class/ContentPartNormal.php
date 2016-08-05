<?php
class ContentPartNormal extends ContentPart {
	
	protected function init() {
		$this->content = '<p>'.$this->contentText.'</p>';
	}

}
?>
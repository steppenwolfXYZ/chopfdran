<?php
class ContentPartSubtitle extends ContentPart {
	
	protected function init() {
		$this->content = '<h2><a name="'.$this->contentText2.'">'.$this->contentText.'</a></h2>';
	}

}
?>
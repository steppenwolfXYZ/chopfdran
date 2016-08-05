<?php
class ContentPartIllustrated extends ContentPartNormal {
	
	protected function init() {
		parent::init();
		$img = '<div style="background-image: url(/'.BASIC_URI.'/images/'.$this->contentText2.'); width: 300px; height: 404px;" class="ctimg illustration"></div>';
		$this->content = $img.$this->content;
	}

}
?>
<?php
class ContentPartLightboxThumb extends ContentPart {
	protected $thumbs;
	
	protected function init() {
		$thumbs = explode(',', $this->contentText2);
		
		$this->content = '<div class="thumbset">';
		
		foreach($thumbs as $thumb) {
			$thumb = trim($thumb);
			$this->content .= '<a href="/'.BASIC_URI.'/image.php?filename='.$thumb.'" data-lightbox="'.$this->contentText.'"><img class="thumb" src="/'.BASIC_URI.'/image.php?filename='.$thumb.'&width=240" alt="" /></a>';
		}
		
		$this->content .= '</div>';
	}

}
?>
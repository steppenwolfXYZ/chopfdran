<?php
class Content extends LayoutPart {
	protected $contentObjects;
		
	protected function setMarkerName() {
		$this->markerName = 'content';
	}
	
	protected function init() {
		$temp = '';
		$row = $this->location->getRow();
		if (!empty($row['content_image'])) {
			$temp .= '<div style="background-image: url(/'.BASIC_URI.'/images/'.$row['content_image'].'); width: '.$row['img_width'].'px; height: '.$row['img_height'].'px;" class="ctimg illustration"></div>';
		}
		
		$temp .= '<h1>'.$this->location->getName().'</h1>';
		
		$stmt = $this->db->prepare('select content.id, content.type, content.content, content.content2 from content inner join navi_content on navi_content.content_id = content.id where navi_content.navi_id = ? order by navi_content.sort');
		$stmt->execute(array($this->location->getId()));
		while($row = $stmt->fetch()) {
			$object = "ContentPart".$row['type'];
			$contentObjects[$row['id']] = new $object($this->db, $row);
			$temp .= $contentObjects[$row['id']]->getContent();
		}
		
		if (!$this->location->getPrintMode()) $temp .= '<br /><br /><a href="'.$this->location->getPrintLink().'" target="_blank" class="printbutton">Druckansicht</a><br /><br />';
		
		$this->content = $temp;
	}
}
?>
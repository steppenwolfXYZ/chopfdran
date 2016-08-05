<?php
class SubNav extends LayoutPart {
	
	protected function setMarkerName() {
		$this->markerName = 'subnav';
	}
	
	protected function init() {
		$temp = '<ul>';
		$stmt = $this->db->prepare("select id, display, url from navi where type = ? and navi_id = ? order by sort");
		$stmt->execute(array(2, $this->location->getId()));
		while($row = $stmt->fetch()) {
			$temp .= '<li><a href="#'.$row['url'].'"';
			$temp .= '>'.$row['display'].'</a></li>';
		}
		$temp .= '</ul>';
		$this->content = $temp;
	}
}
?>
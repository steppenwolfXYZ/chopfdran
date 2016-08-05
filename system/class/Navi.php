<?php
class Navi extends LayoutPart {
	
	protected function setMarkerName() {
		$this->markerName = 'navi';
	}
	
	protected function init() {
		$temp = '<ul class="nav navbar-nav">';
		$stmt = $this->db->prepare("select id, display, url from navi where type = ? order by sort");
		$stmt->execute(array(1));
		while($row = $stmt->fetch()) {
			$temp .= '<li><a href="'.$row['url'].'"';
			if ($this->location->getUri() == $row['url']) $temp .= ' class="active"';
			$temp .= '>'.$row['display'].'</a></li>';
		}
		$temp .= '</ul>';
		$this->content = $temp;
	}
}
?>
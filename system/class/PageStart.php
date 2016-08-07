<?php
class PageStart extends Page {
		
	protected function init() {
		$this->content = '<a href="/'.BASIC_URI.'newproject">Neues Projekt er&ouml;ffnen</a> | Eingeloggt als <b>'.$this->user->getName().'</b> ('.$this->user->getMail().') | <a href="/'.BASIC_URI.'logout">Logout</a><h2 class="formtitle">Deine Projekte</h2>';
		
		$sql = 'SELECT project.id, title, city, description, instrumentation, event_date, project.person_id from project left outer join project_participant on project_participant.project_id = project.id where ifnull(project.person_id, 0) = ? or ifnull(project_participant.person_id, 0) = ? order by event_date';
		$parms = array($this->user->getId(), $this->user->getId());
		$this->content .= $this->createBoxes($sql, $parms);
		$this->content .= '<h2 class="formtitle">Projektvorschl&auml;ge</h2>';
		$sql = 'select project.id, title, city, description, instrumentation, event_date, project.person_id from project left outer join project_participant on project_participant.project_id = project.id and project_participant.person_id = ? where project.instrumentation = ? and project.person_id <> ? and ifnull(project_participant.person_id, 0) = 0 order by event_date';
		$parms = array($this->user->getId(), $this->user->getRow()['instrument_id'], $this->user->getId());
		$this->content .= $this->createBoxes($sql, $parms, true);
		$this->content .= '<div id="js"></div><script type="text/javascript" src="/'.BASIC_URI.'system/js/startpage.js"></script>';
	}
	
	protected function createBox($projectRow, $addButton=false) {
		$box = '<div class="project_box">';
		$box .= '<div class="project_status"><p>Status</p></div>';
		$box .= '<div class="project_content">';
		$box .= '<h3>'.$projectRow['title'].'</h3>';
		if ($addButton) $box .= '<a class="project_add" href="#!" title="Teilnehmen" projectid="'.$projectRow['id'].'">+</a>';
		$box .= '<p>'.$projectRow['city'].', '.formatDate(new DateTime($projectRow['event_date'])).'</p>';
		$box .= '<p>'.str_replace("\r\n", '<br />', $projectRow['description']).'</p>';
		$box .= '</div></div>';
		return $box;
	}
	
	protected function createBoxes($sql, $parms, $addButton=false) {
		$boxes = '';
		$stmt = $this->db->prepare($sql);
		$return = $stmt->execute($parms);
		while($row = $stmt->fetch()) {
			foreach($row as $key=>$value) $row[$key] = utf8_encode($value);
			$boxes .= $this->createBox($row, $addButton);
		}
		return $boxes;
	}
}
?>
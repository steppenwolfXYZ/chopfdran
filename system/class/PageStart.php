<?php
class PageStart extends Page {
		
	protected function init() {
		// eventually login
		if (isset($_SESSION['user_created'])) {
			$this->user->login($_SESSION['user_created']['mail'], $_SESSION['user_created']['pw']);
			unset($_SESSION['user_created']);
		}
		
		$this->content = '<a href="/'.BASIC_URI.'newproject">Neues Projekt er&ouml;ffnen</a> | Eingeloggt als <b>'.$this->user->getName().'</b> ('.$this->user->getMail().') | <a href="/'.BASIC_URI.'logout">Logout</a><h2 class="formtitle">Deine Projekte</h2>';
		
		$sql = 'SELECT project.id, project.title, project.city, project.description, project.event_date, project.person_id, (select count(*) from project_instrumentation x where x.project_id = project.id and x.person_id is null) missing, person.name, person.id person_id from project left outer join project_instrumentation on project_instrumentation.project_id = project.id and project_instrumentation.person_id = ? inner join person on person.id = project.person_id where project.person_id = ? or ifnull(project_instrumentation.id, 0) > 0 order by project.event_date';
		$parms = array($this->user->getId(), $this->user->getId());
		$this->content .= $this->createBoxes($sql, $parms);
		$this->content .= '<h2 class="formtitle">Projektvorschl&auml;ge</h2>';
		$sql = 'select project.id, project.title, project.city, project.description, project.event_date, project.person_id, 1 missing, person.name, person.id person_id from project inner join project_instrumentation on project_instrumentation.project_id = project.id and project_instrumentation.instrument_id = ? and project_instrumentation.person_id is null inner join person on person.id = project.person_id where project.person_id <> ? and (select count(*) from project_instrumentation x where x.project_id = project.id and x.person_id = ?) = 0';
		$parms = array($this->user->getRow()['instrument_id'], $this->user->getId(), $this->user->getId());
		$this->content .= $this->createBoxes($sql, $parms, true);
		$this->content .= '<div id="js"></div><script type="text/javascript" src="/'.BASIC_URI.'system/js/startpage.js"></script>';
	}
	
	protected function createBox($projectRow, $addButton=false) {
		$box = '<div class="project_box">';
		$box .= '<div class="project_status"><div class="status_light'.(($projectRow['missing'])?' status_no':' status_yes').'"></div><p>'.(($projectRow['missing'])?'Durchf&uuml;hrung unsicher':'Findet statt').'</p></div>';
		$box .= '<div class="project_content">';
		$box .= '<h3>'.$projectRow['title'].'</h3>';
		if ($addButton) $box .= '<a class="project_add" href="#!" title="Teilnehmen" projectid="'.$projectRow['id'].'">+</a>';
		$box .= '<p>'.$projectRow['city'].', '.formatDate(new DateTime($projectRow['event_date']));
		if ($projectRow['person_id'] == $this->user->getId()) $box .= '<br /><b>Eigenes Projekt</b></p>';
		else $box .= '<br />von <b>'.$projectRow['name'].'</b></p>';
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
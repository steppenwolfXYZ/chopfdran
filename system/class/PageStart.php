<?php
class PageStart extends Page {
		
	protected function init() {
		// eventually login
		if (isset($_SESSION['user_created'])) {
			$this->user->login($_SESSION['user_created']['mail'], $_SESSION['user_created']['pw']);
			unset($_SESSION['user_created']);
		}
		
		$stmt = $this->db->prepare('select name from instrument join person_instrument on person_instrument.instrument_id = instrument.id where person_instrument.person_id = ?');
		$stmt->execute(array($this->user->getId()));
		$instruments = '';
		while($row = $stmt->fetch()) {
			$instruments .= $row['name'].', ';
		}
		$instruments = substr($instruments, 0, -2);
		$this->content = '<a href="/'.BASIC_URI.'newproject">Neues Projekt er&ouml;ffnen</a> | Eingeloggt als <b>'.$this->user->getName().'</b> ('.$this->user->getMail().' | '.$instruments.') | <a href="/'.BASIC_URI.'logout">Logout</a>';
		
		// select fuer bewertungen
		$this->content .= '<h2 class="formtitle">Zu bewerten</h2>';
		$sql = 'select project.id, project.title, project.city, project.description, project.event_date, project.person_id, project.status, project_status.name status_name, person.name, person.id person_id from project 
			inner join project_application on project_application.project_id = project.id and project_application.status in (\'z\') 
			inner join person on person.id = project_application.person_id 
			inner join project_status on project.status = project_status.code 
			where event_date < now() and person.id = ? order by project.event_date';
		$parms = array($this->user->getId());
		$this->content .=$this->createBoxes($sql, $parms, false, true);
		
		// select fuer eigene projekte und projektteilnahmen
		$this->content .= '<h2 class="formtitle">Deine Projekte</h2>';
		$sql = 'SELECT distinct project.id, project.title, project.city, project.description, project.event_date, project.person_id, project.status, project_status.name status_name, person.name, person.id person_id from project 
			inner join project_application on project_application.project_id = project.id and project_application.status in (\'b\', \'z\') 
			inner join person on person.id = project_application.person_id 
			inner join project_status on project.status = project_status.code 
			where person.id = ? and project.event_date >= now() order by project.event_date';
		$parms = array($this->user->getId());
		$this->content .= $this->createBoxes($sql, $parms);
		$this->content .= '<h2 class="formtitle">Projektvorschl&auml;ge</h2>';
		// select fuer projektvorschlaege
		$sql = 'select distinct project.id, project.title, project.city, project.description, project.event_date, project.person_id, project.status, project_status.name status_name, person.name, person.id person_id from project
			inner join project_instrumentation on project_instrumentation.project_id = project.id and project_instrumentation.instrument_id in (select person_instrument.instrument_id from person_instrument where person_id = ?)
			inner join person on person.id = project.person_id 
			inner join project_status on project.status = project_status.code 
			where project.person_id <> ? and (select count(*) from project_instrumentation x where x.project_id = project.id and x.person_id = ?) = 0 and (select count(*) from project_application where project_application.project_id = project.id and project_application.person_id = ?) = 0 and project.event_date >= now()';
		$parms = array($this->user->getId(), $this->user->getId(), $this->user->getId(), $this->user->getId());
		$this->content .= $this->createBoxes($sql, $parms, true);
		$this->content .= '<div id="js"></div><script type="text/javascript" src="/'.BASIC_URI.'system/js/startpage.js"></script>';
	}
	
	protected function createBox($projectRow, $addButton=false, $rateButton=false) {
		$box = '<div class="project_box">';
		$box .= '<div class="project_status"><div class="status_light'.(($projectRow['status'] == 'u')?' status_no':' status_yes').'"></div><p>'.$projectRow['status_name'].'</p></div>';
		$box .= '<div class="project_content">';
		$box .= '<h3>'.$projectRow['title'].'</h3>';
		$box .= '<a class="project_add" href="/'.BASIC_URI.'project/'.$projectRow['id'].'" title="&Ouml;ffnen"><span class="glyphicon glyphicon-option-horizontal"></span></a>';
		//if ($rateButton) $box .= '<a href="/'.BASIC_URI.'project_feedback/'.$projectRow['id'].'" class="project_rate" title="Bewerten"><span class="glyphicon glyphicon-thumbs-up"></span> <span class="glyphicon glyphicon-thumbs-down"></span></a>';
		$box .= '<p>'.htmlspecialchars($projectRow['city']).', '.formatDateTime(new DateTime($projectRow['event_date']));
		if ($projectRow['person_id'] == $this->user->getId()) $box .= '<br /><b>Eigenes Projekt</b></p>';
		else $box .= '<br />von <b>'.htmlspecialchars(htmlspecialchars($projectRow['name'])).'</b></p>';
		$box .= '<p><b>Instrumente: </b>'.$this->getInstrumentList($projectRow['id']).'</p>';
		$box .= '<p>'.str_replace("\r\n", '<br />', htmlspecialchars($projectRow['description'])).'</p>';
		$box .= '</div>';
		$box .= '<a class="expand" href="/'.BASIC_URI.'project/'.$projectRow['id'].'"><span class="expand glyphicon glyphicon-eye-open"></span></a>';
		$box .= '</div>';
		return $box;
	}
	
	protected function createBoxes($sql, $parms, $addButton=false, $rateButton=false) {
		$boxes = '';
		$stmt = $this->db->prepare($sql);
		$return = $stmt->execute($parms);
		while($row = $stmt->fetch()) {
			foreach($row as $key=>$value) $row[$key] = utf8_encode($value);
			$boxes .= $this->createBox($row, $addButton, $rateButton);
		}
		return $boxes;
	}
	
	protected function getInstrumentList($projectId) {
		$instruments = array();
		$sql = 'select instrument.name from project join person on project.person_id = person.id join person_instrument on person.id = person_instrument.person_id join instrument on instrument.id = person_instrument.instrument_id where project.id = ? union all select instrument.name from project_instrumentation join instrument on project_instrumentation.instrument_id = instrument.id where project_instrumentation.project_id = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array($projectId, $projectId));
		while ($row = $stmt->fetch()) {
			$instruments[] = $row['name'];
		}
		return implode(', ', $instruments);
	}
}
?>
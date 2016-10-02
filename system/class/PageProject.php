<?php
class PageProject extends Page {
		
	protected function init() {
		// select fuer bewertungen
		$this->content .= '<h2 class="formtitle">Projektansicht</h2>';
		$projectId = $this->location->getInfo();
		$sql = 'select project.title, project.city, project.description, project.event_date, project.person_id, person.name, project.status, project_status.name status_name from project join person on person.id = project.person_id join project_status on project_status.code = project.status where project.id = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array($projectId));
		$result = $stmt->fetchAll();
		if (empty($result)) {
			$this->content .= 'Gewähltes Projekt existiert nicht.';
			return;
		} else $project = $result[0];
		
		$stmt = $this->db->prepare('select count(*) count, instrument.name from instrument join project_instrumentation on project_instrumentation.instrument_id = instrument.id where project_instrumentation.project_id = ? group by instrument.id order by instrument.name');
		$stmt->execute(array($projectId));
		$instruments = '';
		while ($row = $stmt->fetch()) {
			$instruments .= $row['name'];
			if ($row['count'] > 1) $instruments .= ' ('.$row['count'].')';
			$instruments .= ', ';
		}
		$instruments = substr($instruments, 0, -2);
		
		$date = new DateTime($project['event_date']);
		$this->content .= '<h1>'.htmlspecialchars(utf8_encode($project['title'])).'</h1>';
		$this->content .= '<div class="projectinfo projectstatus"><div class="status_light'.(($project['status'] == 'u')?' status_no':' status_yes').'"></div><p>'.utf8_encode($project['status_name']).'</p></div><br class="clear" />';
		$this->content .= '<p class="projectinfo">Ort: <b>'.htmlspecialchars(utf8_encode($project['city'])).'</b></p>';
		$this->content .= '<p class="projectinfo">'.formatDateTime($date).'</p>';
		$this->content .= '<p class="projectinfo">Von <b>'.htmlspecialchars(utf8_encode($project['name'])).'</b></p>';
		$this->content .= '<p class="projectinfo">'.$instruments.'</p><br class="clear" />';
		$this->content .= '<p class="projectcontent">'.$project['description'].'</p>';
		
		if (!$this->user->isLoggedIn()) return;
		
		$stmt = $this->db->prepare('select distinct instrument.id, instrument.name from person_instrument join project_instrumentation on person_instrument.instrument_id = project_instrumentation.instrument_id join instrument on person_instrument.instrument_id = instrument.id where project_instrumentation.project_id = ? and person_instrument.person_id = ?');
		$stmt->execute(array($projectId, $this->user->getId()));
		$validInstruments = $stmt->fetchAll();
		if (count($validInstruments) > 0) {
			$this->content .= '<br class="clear" /><div class="projectcontent"><h2>Teilnahme</h2>';
			$stmt = $this->db->prepare('select instrument_id, application_timestamp, status, instrument.name from project_application join instrument on instrument.id = project_application.instrument_id where project_id = ? and person_id = ?');
			$stmt->execute(array($projectId, $this->user->getId()));
			$applications = $stmt->fetchAll();
			$status = 'n';
			foreach($applications as $key=>$application) {
				switch($application['status']) {
					case 'b': // beworben
						$status = 'b';
						break 2;
					case 't': // bewertet
						$status = 't';
						$zugewiesenRow = $key;
						break 2;
					case 'z': // zugewiesen
						$zugewiesenRow = $key;
						$status = 'z';
						break 2;
					case 'w': // abgewiesen
						$status = 'w';
						break;
				}
			}
			
			$instrumentsArray = array();
			foreach ($applications as $application) $instrumentsArray[] = $application['name'];
			
			$feedback = false;
			
			switch ($status) {
				case 'w':
					$this->content .= 'Dieses Projekt findet statt, funktioniert aber besser ohne dich.';
					break;
				case 'z':
					$this->content .= '<div class="applicationBox">Du wurdest f&uuml;r dieses Projekt ausgew&auml;hlt, und zwar mit dem Instrument <b>'.$applications[$zugewiesenRow]['name'].'</b>.</div><div class="applicationBox">';
					$stmt = $this->db->prepare('select person.name person_name, instrument.name instrument_name from project_application join person on project_application.person_id = person.id join instrument on project_application.instrument_id = instrument.id where project_application.project_id = ? and project_application.status = \'z\'');
					$stmt->execute(array($projectId));
					while ($row = $stmt->fetch()) {
						$this->content .= $row['person_name'].': '.$row['instrument_name'].'<br />';
					}
					$this->content .= '</div>';
					$feedback = true;
					break;
				case 't':
					$this->content .= 'Du hast bei diesem Projekt mit <b>'.$applications[$zugewiesenRow]['name'].'</b> teilgenommen und die Bewertung bereits erledigt.';
					break;
				case 'b':
					$this->content .= 'Du hast dich f&uuml;r dieses Projekt mit <b>'.explodeOr($instrumentsArray).'</b> beworben.';
					break;
				case 'n':
					$this->content .= '<div class="applicationBox">Du kannst dich f&uuml;r dieses Projekt bewerben. W&auml;hle die Instrumente aus, mit denen du bereit bist, an diesem Projekt teilzunehmen. Wenn du f&uuml;r das Projekt ausgew&auml;hlt wirst, wird f&uuml;r dich automatisch das beste Instrument ausgew&auml;hlt.</div>';
					$this->content .= '<form action="/'.BASIC_URI.'project/'.$projectId.'" method="post"><div class="applicationBox">';
					foreach ($validInstruments as $instrument) {
						$this->content .= '<input type="checkbox" name="instrument['.$instrument['id'].']" value="'.$instrument['name'].'" checked="checked" /> '.$instrument['name'].'<br />';
					}
					$this->content .= '<input type="hidden" name="mode" value="add_project_application" /><input type="hidden" name="projectId" value="'.$projectId.'" /><input type="submit" class="applicationSubmit" value="Bewerben" /></form>';
			}
			
			if ($feedback) {
				$this->content .= '<br /><button class="applicationSubmit" onclick="window.location.href=\'/'.BASIC_URI.'project_feedback/'.$projectId.'\';">Bewerten</button>';
			}
			$this->content .= '</div>';
			$this->content .= '<script type="text/javascript" src="/'.BASIC_URI.'system/js/form.js"></script>';
		}
	}
	
}
?>
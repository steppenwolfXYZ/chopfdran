<?php
class PageProjectFeedback extends Page {
		
	protected function init() {
		// select fuer bewertungen
		$this->content .= '<h2 class="formtitle">Mitmusiker bewerten</h2>';
		$projectId = $this->location->getInfo();
		$sql = 'select project.title, project.event_date from project join project_application on project.id = project_application.project_id where project_application.person_id = ? and project_application.status in (\'z\') and project.id = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array($this->user->getId(), $projectId));
		$result = $stmt->fetchAll();
		if (empty($result)) {
			$this->content .= 'Gewähltes Projekt existiert nicht oder darf nicht bewertet werden.';
			return;
		}
		
		$date = new DateTime($result[0]['event_date']);
		$this->content .= '<p>'.htmlspecialchars(utf8_encode($result[0]['title'])).', '.formatDateTime($date).'</p>';
		
		$this->content .= '<form action="/'.BASIC_URI.'start" method="get">';
		
		$sql = 'select person.id person_id, person.name person_name, person_instrument.id person_instrument_id, instrument.name instrument_name from project_application
			inner join person on project_application.person_id = person.id
			inner join person_instrument on person_instrument.person_id = person.id and person_instrument.instrument_id = project_application.instrument_id
			inner join instrument on project_application.instrument_id = instrument.id
			where project_application.project_id = ? and project_application.person_id <> ? and project_application.status in (\'z\', \'t\')';
			
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array($projectId, $this->user->getId()));
		while ($row = $stmt->fetch()) {
			$this->content .= '<div class="feedback_line"><div class="feedback_name">'.htmlspecialchars(utf8_encode($row['person_name'])).'<br />';
			$this->content .= htmlspecialchars(utf8_encode($row['instrument_name']));
			$this->content .= '</div><div class="feedback_slider_container"><input class="feedback_slider" type="text" data-slider-value="0" data-slider-id="feedback-slider" name="feedback['.$row['person_instrument_id'].']" /></div>';

			$this->content .= '</div>';
		}
		
		$this->content .= '<div id="js"></div><script type="text/javascript" src="/'.BASIC_URI.'system/js/project_feedback.js"></script>';
		$this->content .= '<div class="formline"><label class="normal"><input type="button" value="Abbrechen" class="form_button cancel_button" onclick="javascript:window.location.href = \'/'.BASIC_URI.'start\';" /></label><input type="submit" name="projectFeedbackSubmit" value="Juhu fertig!" class="form_button" /></div>
		<input type="hidden" name="mode" value="project_feedback" />
		<input type="hidden" name="project_id" value="'.$projectId.'" />
		</form>';
	}
	
}
?>
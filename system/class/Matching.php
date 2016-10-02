<?php
class Matching extends DBObject {
	private $positions = array();
	private $options;
	private $personPerOption;
	private $personInstrumentPerOption;
	private $feedbackPerOption;
	private $invalidOptions;
	private $creator;
	private $numberOfPositions;
	
	public function addPerson($position, $personId, $personInstrumentId, $timestamp) {
		$this->positions[$position][] = $this->getPositionPart($personId, $personInstrumentId, $timestamp);
	}
	
	public function makeMatching() {
		for ($i=0; $i<$this->numberOfPositions; $i++) {
			if (empty($this->positions[$i])) return false;
		}
		$this->getOptions();
		// pruefen, ob mindestens eine valide option
		if (empty($this->options)) return false;
		
		$this->addFeedback();
		return $this->getBestOption();
	}
	
	public function addProject($projectId) {
		$stmt = $this->db->prepare('select instrument_id from project_instrumentation where project_id = ?');
		$stmt->execute(array($projectId));
		$i = 0;
		while ($row = $stmt->fetch()) {
			$stmt2 = $this->db->prepare('select project_application.person_id, person_instrument.id, application_timestamp from project_application join person_instrument on person_instrument.person_id = project_application.person_id and person_instrument.instrument_id = project_application.instrument_id where project_application.project_id = ? and project_application.instrument_id = ?');
			$stmt2->execute(array($projectId, $row['instrument_id']));
			while ($row2 = $stmt2->fetch()) {
				$this->addPerson($i, $row2['person_id'], $row2['id'], $row2['application_timestamp']);
			}
			$i ++;
		}
		
		$stmt = $this->db->prepare('select person_id from project where id = ?');
		$stmt->execute(array($projectId));
		$this->creator = $stmt->fetchAll()[0]['person_id'];
		
		$this->setNumberOfPositions($i);
	}
	
	public function setCreator($creator) {
		$this->creator = $creator;
	}
	
	public function setNumberOfPositions($positions) {
		$this->numberOfPositions = $positions;
	}
	
	private function getPositionPart($personId, $personInstrumentId, $timestamp) {
		$ret['personInstrumentId'] = $personInstrumentId;
		$ret['personId'] = $personId;
		$ret['timestamp'] = $timestamp;
		$ret['feedback'] = 0;
		return $ret;
	}
	
	private function getOptions() {
		$options = array();
		$positionRaise = array();
		
		$optionCount = 1;
		foreach ($this->positions as $positionId=>$positionOptions) {
			$positionOptionCount[$positionId] = count($positionOptions);
			$positionRaise[$positionId] = 0;
			$optionCount *= $positionOptionCount[$positionId];
		}
		
		for ($i=0; $i<$optionCount; $i++) {	
			$usedPersons = array();
			
			$optionPart = array();
			$personSave = array();
			$personInstrumentSave = array();
			$complete = true;
			foreach ($this->positions as $positionId=>$positionOptions) {
				foreach ($positionOptions as $key=>$position) {
					// positionRaise beruecksichtigen
					if ($positionRaise[$positionId] > $key) continue;
					
					// wurde die person in diesem durchlauf schon verwendet?
					if (isset($usedPersons[$position['personId']])) continue;
										
					$usedPersons[$position['personInstrumentId']] = true;
					$personSave[] = $position['personId'];
					$personInstrumentSave[] = $position['personInstrumentId'];
					$optionPart[$positionId] = $position;
					break;
				}
				if (empty($optionPart[$positionId])) {
					// eine position konnte nicht besetzt werden
					$complete = false;
					break;
				}
			}

			if (!empty($optionPart) && $complete && $this->isOptionNew($options, $optionPart) && $this->isCreatorInvolved($optionPart)) {
				$optionKey = count($options);
				$this->options[$optionKey] = $optionPart;
				$this->personPerOption[$optionKey] = $personSave;
				$this->personInstrumentPerOption[$optionKey] = $personInstrumentSave;
				
			}
			
			// position raise setzen
			foreach ($positionRaise as $positionId=>$value) {
				if ($value == $positionOptionCount[$positionId] - 1) {
					// reset
					$positionRaise[$positionId] = 0;
				} else if ($value < $positionOptionCount[$positionId] -1) {
					// raise
					$positionRaise[$positionId] ++;
					break;
				}
			}

		}
	}
	
	private function isOptionNew($options, $option) {		
		foreach ($options as $refOption) {
			$same = true;
			foreach($refOption as $positionId=>$position) {
				if ($position['personInstrumentId'] != $option[$positionId]['personInstrumentId']) {
					$same = false;
				}
			}
			if ($same) return false;
		}
		return true;
	}
	
	private function isCreatorInvolved($option) {		
		foreach ($option as $position) {
			if ($position['personId'] == $this->creator) return true;
		}
		
		return false;
	}
	
	private function addFeedback() {	
		foreach ($this->options as $key=>$option) {
			$stmt = $this->db->prepare($this->getFeedbackSql($this->personPerOption[$key], $this->personInstrumentPerOption[$key]));
			$stmt->execute();
			$valid = true;
			$this->feedbackPerOption[$key] = 0;
			while ($row = $stmt->fetch()) {
				// suchen, wo das feedback gesetzt werden kann
				foreach ($option as $positionId=>$position) {
					if ($position['personInstrumentId'] == $row['feedback_for_person_instrument_id']) {
						if ($row['value'] == -2) $valid = false;
						$position['feedback'] += $row['value'];
						$this->feedbackPerOption[$key] += $row['value'];
						break;
					}
				}
			}
			
			if (!$valid) $this->invalidOptions[$key] = true;
		}
	}
		
	private function getFeedbackSql($person, $personInstrument) {
		$sql = 'select person_id, feedback_for_person_instrument_id, value from project_feedback where (person_id in('.implode($person, ',').')) or (feedback_for_person_instrument_id in ('.implode($personInstrument, ',').')) order by feedback_timestamp desc';
		return $sql;
	}
	
	private function getBestOption() {
		arsort($this->feedbackPerOption);
		foreach ($this->feedbackPerOption as $key=>$value) {
			if (!isset($this->invalidOptions[$key])) {
				return $this->options[$key];
			}
		}
		return false;
	}
}
?>
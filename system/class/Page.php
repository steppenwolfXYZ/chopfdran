<?php
abstract class Page extends DBObject {
	protected $location;
	protected $content;
	protected $user;
	
	public function __construct(PDO $db, Location $location, User $user) {
		parent::__construct($db);
		$this->location = $location;
		$this->user = $user;
		$this->init();
	}
	
	abstract protected function init();
	
	public function getContent() {
		return $this->content;
	}
	
	protected function generateInstrumentationSelect($name) {
		$instrumentationSelect = '<select class="input instrumentSelect" name="'.$name.'">
				<option value=""></option>';
		$stmt = $this->db->prepare('select id, name from instrument order by name');
		$stmt->execute();
		while($row = $stmt->fetch()) {
			$instrumentationSelect .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		$instrumentationSelect .= '</select>';
		
		return $instrumentationSelect;
	}

}
?>
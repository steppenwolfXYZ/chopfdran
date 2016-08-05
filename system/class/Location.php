<?php
class Location extends DBObject {
	protected $uri;
	protected $id;
	protected $name;
	protected $row;
	protected $printMode = false;
	
	public function __construct(PDO $db) {
		parent::__construct($db);
		
		$this->uri = $_SERVER['REQUEST_URI'];
		
		if (substr($this->uri, 0, 1) == '/') $this->uri = substr($this->uri, 1);
		
		if (substr($this->uri, 0, strlen(BASIC_URI)) == BASIC_URI) {
			$this->uri = trim(substr($this->uri, strlen(BASIC_URI)));
			if (substr($this->uri, 0, 1) == '/') $this->uri = substr($this->uri, 1);
			if (substr($this->uri, -1, 1) == '/') $this->uri = substr($this->uri, 0, -1);
			if (substr($this->uri, 0, 6) == 'print/') {
				$this->uri = substr($this->uri, 6);
				$this->printMode = true;
			}
		
			$stmt = $this->db->prepare('select id, display, content_image, img_width, img_height from navi where url = ?');
			$stmt->execute(array($this->uri));
			$result = $stmt->fetchAll();
			if (empty($result)) {
				$this->id = 0;
				$this->name = '';
			} else {
				$this->id = $result[0]['id'];
				$this->name = utf8_encode($result[0]['display']);
				$this->row = $result[0];
			}
		} // else exception	
	}
	
	public function getId() { return $this->id; }
	public function getUri() { return $this->uri; }
	public function getName() { return $this->name; }
	public function getRow() { return $this->row; }
	public function getPrintMode() { return $this->printMode; }
	
	public function getPrintLink() {
		return '/'.BASIC_URI.'/print/'.$this->uri;
	}
}
?>
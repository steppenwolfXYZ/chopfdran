<?php
class Location extends DBObject {
	protected $page;
	protected $info;
	protected $id;
	protected $row;
	protected $user;
	
	public function __construct(PDO $db, User $user) {
		parent::__construct($db);
		
		$this->user = $user;
		$uri = $_SERVER['REQUEST_URI'];
		
		$i = 0;		
		$uriParts = explode('/', $uri);

		if (isset($uriParts[$i])) {
			if (empty($uriParts[$i])) $i++;
			
			if (isset($uriParts[$i]) && $uriParts[$i].'/' == BASIC_URI) $i++;
			
			if (isset($uriParts[$i])) {
				$this->page = $uriParts[$i];
				$i++;
			}
			
			if (isset($uriParts[$i])) {
				$this->info = $uriParts[$i];
			}
				
			$result = $this->getNaviRow($this->page);
			if (empty($result)) {
				$this->id = 0;
				$this->name = '';
				$this->setDefaultPage();
			} else {
				$this->id = $result['id'];
				$this->row = $result;
			}
		}
	}
	
	private function setDefaultPage() {
		if ($this->user->isLoggedIn()) {
			$result = $this->getNaviRow('start');
			$this->id = $result['id'];
			$this->row = $result;
		} else {
			$result = $this->getNaviRow('login');
			$this->id = $result['id'];
			$this->row = $result;
		}
	}
	
	private function getNaviRow($url) {
		$stmt = $this->db->prepare('select id, object, name from page where url = ?');
		$stmt->execute(array($url));
		$result = $stmt->fetchAll();
		if (empty($result)) return array();
		else return $result[0];
	}
	
	public function getId() { return $this->id; }
	public function getPage() { return $this->page; }
	public function getInfo() { return $this->info; }
	public function getRow() { return $this->row; }
	public function getUser() { return $this->user; }
}
?>
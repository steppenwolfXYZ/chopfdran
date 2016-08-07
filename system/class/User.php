<?php
class User extends DBObject {
	private $status;
	private $mail;
	private $userId;
	private $name;
	private $row;
	const STATUS_LOGGED_IN = true;
	const STATUS_LOGGED_OUT = false;
	
	public function __construct(PDO $db) {
		parent::__construct($db);
		
		session_start();
		
		$this->checkSession();
	}
	
	public function isLoggedIn() {
		return $this->status;
	}
	
	public function login($mail, $pw) {
		$stmt = $this->db->prepare("select id, name, mail, pw, title, birthdate, city, instrument_id from person where mail = ?");
		$stmt->execute(array($mail));
		$result = $stmt->fetchAll();
		if (empty($result)) {
			return false;
		} else {
			if (password_verify($pw, $result[0]['pw'])) {
				$this->status = $this::STATUS_LOGGED_IN;
				$this->name = $result[0]['name'];
				$this->mail = $result[0]['mail'];
				$this->userId = $result[0]['id'];
				$this->row = $result[0];
				$this->setSession($this::STATUS_LOGGED_IN);
				return true;
			} else return false;
		}
	}
	
	public function logout() {
		$this->status = $this::STATUS_LOGGED_OUT;
		unset($this->mail);
		unset($this->name);
		unset($this->userId);
		$this->setSession($this::STATUS_LOGGED_OUT);
	}
	
	public function getMail() { return $this->mail; }
	public function getId() { return $this->userId; }
	public function getName() { return $this->name; }
	public function getRow() { return $this->row; }
	
	private function checkSession() {
		if (isset($_SESSION['user'])) {
			$this->mail = $_SESSION['user']['mail'];
			$this->name = $_SESSION['user']['name'];
			$this->userId = $_SESSION['user']['userId'];
			$this->row = $_SESSION['user']['row'];
			$this->status = $this::STATUS_LOGGED_IN;
		} else {
			$this->logout();
		}
	}
	
	private function setSession($status) {
		if ($status) {
			$_SESSION['user']['mail'] = $this->mail;
			$_SESSION['user']['userId'] = $this->userId;
			$_SESSION['user']['name'] = $this->name;
			$_SESSION['user']['row'] = $this->row;
		} else {
			unset($_SESSION['user']);
		}
	}
}
?>
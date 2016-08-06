<?php
class User extends DBObject {
	private $status;
	private $userName;
	const STATUS_LOGGED_IN = true;
	const STATUS_LOGGED_OUT = false;
	
	public function isLoggedIn() {
		return $this->status;
	}
	
	public function login($user, $pw) {
		$stmt = $this->db->prepare("select id, name from person where name = ? and pw = ?");
		$stmt->execute(array($user, password_hash($pw)));
		$result = $stmt->fetchAll();
		if (empty($result)) {
			return false;
		} else {
			$this->status = STATUS_LOGGED_IN;
			$this->userName = $result[0]['name'];
			return true;
		}
	}
	
	public function logout() {
		$status = STATUS_LOGGED_OUT;
		$userName = '';
	}
	
	public getUserName() {return $this->userName;}
}
?>
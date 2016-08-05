<?php
abstract class DBObject {
	protected $db;
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}
}
?>
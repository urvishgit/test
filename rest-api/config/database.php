<?php
namespace Database;

use \PDO;

class db {
	private $host = 'localhost';
	private $username = 'root';
	private $password = '';
	private $dbname = 'wallet_api';
	
	public $connection;
	
	public function GetConnection(){
		
		$this->connection = null;
		
		try{
			$this->connection = new \PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->username,$this->password);
			$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}catch(\PDOException $exception){
			http_response_code(500);
			echo json_decode('Connection Error:'.$exception->getMessage());
			exit;
		}
		return $this->connection;
	}
	
}
?>
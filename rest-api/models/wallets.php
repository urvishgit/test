<?php
namespace Models;

use \PDO;

class Wallets_model {

	public $id;
	public $name;
	public $hashkey;
	
	private $table_name = 'wallet';
	private $connection;
	
	public function __construct($db){
		$this->connection = $db;
	}
	
	public function get($id = null, $name = null, $hashkey = null) {
		
		$wallets = null;
		
		$where = " WHERE 1";
				
		if($id){
			$where .= " AND id =".$id;
		}
		
		if($name){
			$where .= " AND name ='".$name."'";
		}
		
		if($hashkey){
			$where .= " AND hashkey ='".$hashkey."'";
		}
		
		try {
			
			$sql = "SELECT * FROM ". $this->table_name . $where;
			$stmt = $this->connection->query($sql);
			$wallets = $stmt->fetch();
			
		} catch(\PDOException $e) {
			
			http_response_code(500);
			echo json_encode('Database Error:'.$e);
			exit;
			
		}
		
		return $wallets;
		
	}
	public function insert($input){
		
		if(!$input) return;
		
		try{
			$data = [
			'name' => $input->name,
			'hashkey' => md5($input->hashkey),
			];
			
			$sql = "INSERT INTO " .$this->table_name. " (name, hashkey) VALUES(:name, :hashkey)";
			$this->connection->prepare($sql)->execute($data);
		
			$wallet_id = $this->connection->lastInsertId();
			
			if($wallet_id) {
				$wallet = $this->get($wallet_id);
				return $wallet;
			}
			
		} catch(\PDOException $e) {
			
			http_response_code(500);
			echo json_encode('Database Error:'.$e);
			exit;
			
		}
		
	}
	
	public function delete($id){
		
		if(!$id) return;
		
		try {
			
			$sql = "DELETE FROM ".$this->table_name." WHERE id = ".$id;
			$this->connection->prepare($sql)->execute();
			
			return true;
			
		} catch(\PDOException $e) {
			http_response_code(500);
			echo json_encode('Database Error'.$e);
			exit;
		}
		return;
	}	
}
?>
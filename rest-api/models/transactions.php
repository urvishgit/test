<?php
namespace Models;

use \PDO;

class Transactions_model {

	public $id;
	public $name;
	public $type;
	public $amount;
	public $reference;
	public $tsp;
	
	private $table_name = 'transaction';
	private $connection;
	
	public function __construct($db){
		$this->connection = $db;
	}
	
	public function get($id = null) {
		
		$transactions = null;
		
		$where = " WHERE 1";
				
		if($id){
			$where .= " AND id =".$id;
		}
		
		try {
			
			$sql = "SELECT * FROM ". $this->table_name . $where;
			$stmt = $this->connection->query($sql);
			$transactions = $stmt->fetch();
			
		} catch(\PDOException $e) {
			
			http_response_code(500);
			echo json_encode('Database Error:'.$e);
			exit;
			
		}
		
		return $transactions;
		
	}
	public function insert($input){
		
		if(!$input) return;
		
		try{
			$data = [
			'wallet_link' => $input->wallet_link,
			'type' => $input->type,
			'amount' => $input->amount,
			'reference' => $input->reference,
			'tsp' => time(),
			];
			
			$sql = "INSERT INTO " .$this->table_name. " (wallet_link, type, amount, reference, tsp) VALUES(:wallet_link, :type, :amount, :reference, :tsp)";
			$this->connection->prepare($sql)->execute($data);
		
			$transaction_id = $this->connection->lastInsertId();
			
			if($transaction_id) {
				$transaction = $this->get($transaction_id);
				return $transaction;
			}
			
		} catch(\PDOException $e) {
			
			http_response_code(500);
			echo json_encode('Database Error:'.$e);
			exit;
			
		}
		
	}	
}
?>
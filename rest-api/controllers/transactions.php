<?php
namespace Controllers;

use \Database\DB;
use \FormValidation\Form_Validation;


use \Models\Wallets_model;
use \Models\Transactions_model;

class Transactions {
	
	public $id;
	public $name;
	public $hashkey;
	public $conn;
	
	public $RequestMethod;
	public $data_validation;
	
	private $connection;
	
	public function __construct($RequestMethod) {
		$this->RequestMethod = $RequestMethod;
	}
	
	public function AddTransaction() {
	
		if(strtolower($this->RequestMethod) != 'post'){
			http_response_code(405);
			echo json_encode('Method not allowed.');
			exit;
		}
		
		if(!isset($_POST['name']) || !isset($_POST['type']) || !isset($_POST['amount']) || !isset($_POST['reference'])) {
			http_response_code(403);
			echo json_encode('Name, Type, Amount, Reference is required.');
			exit;
		}
		
		$valid_type = false;
		$valid_amount = false;
		$valid_reference = false;
		
		$this->name = $_POST['name'];
		$this->type = $_POST['type'];
		$this->amount = $_POST['amount'];
		$this->reference = $_POST['reference'];
		
		$this->data_validation = new Form_Validation();
		
		$this->data_validation->validate(array('name','Name','required|<3|>255'));
		$this->data_validation->validate(array('type','Type','required'));
		$this->data_validation->validate(array('amount','Amount','required'));
		$this->data_validation->validate(array('reference','Reference','required'));
		
		if($this->data_validation->is_form_ok() == false){
			http_response_code(403);
			echo json_encode('Error: Please enter valid input.');
			exit;
		}		
		
		$valid_type = $this->valid_type($this->type);
		$valid_amount = $this->valid_amount($this->type, $this->amount);
		$valid_reference = $this->valid_reference($this->reference);
		
		if($valid_type == false || $valid_amount == false || $valid_reference == false){
			http_response_code(500);
			echo json_encode('Error: Please enter valid input.');
			exit;
		} 
			
		$database = new DB();
		$db = $database->GetConnection();
		
		$wallet_obj = new Wallets_model($db);
		$wallet = $wallet_obj->get(null, $this->name);
		
		if(!$wallet) {
			http_response_code(500);
			echo json_encode('Error: Wallet is not exists.');
			exit;
		} else {
			$_POST['wallet_link'] = $wallet['id'];
			$this->wallet_link = $_POST['wallet_link'];
			
			$transaction_obj = new Transactions_model($db);
			$transaction = $transaction_obj->insert($this);
			http_response_code(200);
			echo json_encode($transaction);
			exit;
		}
		return;
	}	

	private function valid_type($type) {
		if(!$type) return false;
		
		if(strtolower($type) == 'bet' || strtolower($type) == 'win'){
			return true;
		}
		return false;
	}
	
	private function valid_amount($type, $amount) {
		if(!$type || !$amount) return false;
		
		if(strtolower($type) == 'bet' && $amount <=0){
			return true;
		}
		if(strtolower($type) == 'win' && $amount >=0){
			return true;
		}
	}
	
	private function valid_reference($reference) {
		if(!$reference) return false;
		
		if(substr($reference, 0,3) === 'TR-') {
			return true;
		}
		return false;
	}
}
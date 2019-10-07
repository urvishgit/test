<?php
namespace Controllers;

use \Database\DB;
use \FormValidation\Form_Validation;

use \Models\Wallets_model;

class Wallets {
	
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
	
	public function CreateWallet() {
	
		if(strtolower($this->RequestMethod) != 'post'){
			http_response_code(405);
			echo json_encode('Method not allowed.');
			exit;
		}
		
		if(!isset($_POST['name']) && !isset($_POST['hashkey'])) {
			http_response_code(403);
			echo json_encode('Name and Hashkey is required.');
			exit;
		}
		
		$this->name = $_POST['name'];
		$this->hashkey = $_POST['hashkey'];
		
		$this->data_validation = new Form_Validation();
		
		$this->data_validation->validate(array('name','Name','required|<3|>255'));
		$this->data_validation->validate(array('hashkey','Hashkey','required|<3|>255'));
		
		if($this->data_validation->is_form_ok() == false){
			http_response_code(403);
			echo json_encode('Error: Please enter valid input.');
			exit;
		}
		
		$database = new DB();
		$db = $database->GetConnection();
		
		$wallet_obj = new Wallets_model($db);
		$wallet = $wallet_obj->get(null, $this->name);
		
		if($wallet) {
			http_response_code(500);
			echo json_encode('Error: Wallet is alredy exists.');
			exit;
		} else {
			$wallet = $wallet_obj->insert($this);
			http_response_code(200);
			echo json_encode($wallet);
			exit;
		}
		return;
	}	


	public function DeleteWallet() {
	
		if(strtolower($this->RequestMethod) != 'post'){
			http_response_code(405);
			echo json_encode('Method not allowed.');
			exit;
		}
		
		if(!isset($_POST['name']) && !isset($_POST['hashkey'])) {
			http_response_code(403);
			echo json_encode('Name and Hashkey is required.');
			exit;
		}
		
		$this->name = $_POST['name'];
		$this->hashkey = $_POST['hashkey'];
		
		$this->data_validation = new Form_Validation();
		
		$this->data_validation->validate(array('name','Name','required|<3|>255'));
		$this->data_validation->validate(array('hashkey','Hashkey','required|<3|>255'));
		
		if($this->data_validation->is_form_ok() == false){
			http_response_code(403);
			echo json_encode('Error: Please enter valid input.');
			exit;
		}
		
		$database = new DB();
		$db = $database->GetConnection();
		
		$wallet_obj = new Wallets_model($db);
		$wallet = $wallet_obj->get(null, $this->name);
		
		if($wallet) {
			$wallet = $wallet_obj->delete($wallet['id']);
			http_response_code(200);
			exit;
		} else {
			http_response_code(500);
			echo json_encode('Error: Wallet is not exists.');
			exit;
		}
		return;
	}		
}
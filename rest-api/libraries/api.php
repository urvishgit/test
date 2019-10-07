<?php
namespace API;

require('config/database.php');
require('libraries/Form_Validation.php');

require('controllers/wallets.php');
require('controllers/transactions.php');

require('models/wallets.php');
require('models/transactions.php');


use \database\DB;

use \Controllers\Wallets;
use \Controllers\Transactions;

class WalletAPI {
	
	public $httpMethod;
	public $httpRequestURI;
	public $page;
	
	private $allow_uri = ['home', 'create-wallet', 'delete-wallet', 'add-transaction'];
	
	public function __construct(){
		
		$this->page = 'home';
		$this->httpMethod = $_SERVER['REQUEST_METHOD'];
		$this->httpRequestURI = !empty(explode('/', $_SERVER['REQUEST_URI'])[2]) ? explode('/', $_SERVER['REQUEST_URI'])[2] : 'home';
		
	}
	public function SetPage() {
		if(in_array($this->httpRequestURI, $this->allow_uri)){
			$this->page = $this->httpRequestURI;
		} else {
			$this->page = '404';
		}
		//echo $this->page;
		//exit;
		return $this->page;
	}
	
	public function SetPageCall() {
		
		if($this->httpRequestURI == 'CreateWallet') {
			$wallet_obj = new Wallets($this->httpMethod);
			$wallet_obj->CreateWallet();			
		}
		if($this->httpRequestURI == 'DeleteWallet') {
			$wallet_obj = new Wallets($this->httpMethod);
			$wallet_obj->DeleteWallet();			
		}
		if($this->httpRequestURI == 'AddTransaction') {
			$transaction_obj = new Transactions($this->httpMethod);
			$transaction_obj->AddTransaction();			
		}
		return;
	}
}
?>
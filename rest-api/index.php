<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('libraries/api.php');

use API\WalletAPI;

$route = new WalletAPI();
$route->SetPageCall();
$page = $route->SetPage();

?>
<html>
<head>
	<title>Welcome to Wallet API</title>
<link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<?php include('views/header.php');?>
		</div>
		<div class="row">
			<?php include('views/'.$page.'.php');?>
		</div>
		<div class="row">
			<?php include('views/footer.php');?>
		</div>
	</div>
</body>
</html>
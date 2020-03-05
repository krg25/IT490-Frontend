<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<?php include("header.php"); ?>
<div class="content">
<div class="container">


<?php
ini_set('display_errors',1);
require_once('rabbit/path.inc');
require_once('rabbit/get_host_info.inc');
require_once('rabbit/rabbitMQLib.inc');


if (isset($_POST["symbol"])){
$client = new rabbitMQClient("rabbit/rabbit.ini","database");

$request['type'] = "Transaction";
$request['sub'] = 1;
$request['user_id'] = $_POST['user_id'];
$request['symbol'] = $_POST['symbol'];
$request['price'] = $_POST['price'];
$request['qty'] = $_POST['qty'];

$response = $client->send_request($request);

switch($response['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
		echo ("Good?"); //the fuck do I know, i give up
		header("location: /portfolio.php");
		break;
	case 2:
		echo ("
		<header>
		<h1>Error creating transaction.</h1>
		</header>
		");
		break;


}//switch


}else{
echo ("
<header>
<h1>No stock specified!</h1>
</header>
");
}


?>
</div>
</div>
</body>
</html>

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


if (isset($_GET["search"])){
$client = new rabbitMQClient("rabbit/rabbit.ini","database");

$request['type'] = "API";
$request['symbol'] = $_GET["search"];

$response = $client->send_request($request);

switch($response['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
		echo ("
		<header>
		<h1><a href = https://finance.yahoo.com/quote/".$response['symbol'].">".$response['symbol']."</a>, Current Price: $".$response['price']."</h1></br>
		<header>
	<table>
	<tr>
		<td>Open:</td><td>$".$response['open']."</td>
	</tr>
	<tr>
		<td>High: </td><td>$".$response['high']."</td>
	</tr>
	<tr>
		<td>Low: </td><td>$".$response['low']."</td>
	</tr>
	<tr>
		<td>Previous Close: </td><td>$".$response['prvclose']."</td>
	</tr>
	<tr>
		<td>Volume: </td><td>".$response['volume']."</td>
	</tr>
	</table>
		");
		break;
	case 2:
		echo ("
		<header>
		<h1>Stock \"".$_GET['search']."\" not found.</h1>
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

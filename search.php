<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
	</tr>");
if(isset($_SESSION['ID'])){
	echo("<tr>
		
		<form action=\"transaction.php\" name=\"buy\" id=\"buy\" method=\"post\">
		<td>		
		<input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=".$_SESSION['ID'].">
		<input type=\"hidden\" id=\"symbol\" name=\"symbol\" value=".$_GET['search'].">
		<input type=\"hidden\" id=\"price\" name=\"price\" value=".$response['price'].">
		<input type=\"number\" id=\"qty\" name=\"qty\" step=\"1\" required>
		</td>
		<td>
		<button type=\"submit\" name=\"submit\" id=\"submit\">Execute</button>
		</td>
		</form>
		
	</tr>");
}
		echo("</table>");
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

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


if (isset($_SESSION['ID'])){
$client = new rabbitMQClient("rabbit/rabbit.ini","database");

$request['type'] = "Transaction";
$request['ID'] = $_SESSION['ID'];
$request['sub'] = 2;

$response = $client->send_request($request);

switch($response[0]['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
echo("<table style=\"width:100%\"><tr><th>Time</th><th>Transaction #</th><th align=left>Symbol</th><th>Quantity</th><th align=right>Unit Price</th><th align=right>Total Price</th></tr>"); 

		for ($i=1; $i<count($response); $i++){
echo("

	<tr>
		<td align=center>".$response[$i]['time']."</td>			
		<td align=center>".$response[$i]['trid']."</td>
		<td align=left>".$response[$i]['symbol']."</td>
		<td align=center>".$response[$i]['qty']."</td>
		<td align=right>$".money_format("%i",($response[$i]['price']))."</td>
		<td align=right>$".money_format("%i",($response[$i]['price']*$response[$i]['qty']))."</td>	

			
	</tr>

");


}
echo("</table>");
		break;
	case 2:
		echo ("
		<header>
		<h1>Transactions not found.</h1>
		</header>
		");
		break;


}//switch


}else{
echo ("
<header>
<h1>No user specified!</h1>
</header>
");
}

?>




</div>
</div>
</body>
</html>

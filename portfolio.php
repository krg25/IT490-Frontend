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


if (isset($_SESSION['ID'])){
$client = new rabbitMQClient("rabbit/rabbit.ini","database");

$request['type'] = "Portfolio";
$request['ID'] = $_SESSION['ID'];

$response = $client->send_request($request);

switch($response[0]['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
echo("
<header>
<h1>".$_SESSION['user']."\tCash Balance: $".money_format("%i",($response[0]['wallet']))."
</header>

");
echo("<table style=\"width:100%\"><tr><th align=left>Symbol</th><th>Owned</th><th align=right>Initial Price</th><th align=right>Current Price</th><th align=right>Change</th></tr>"); 
	$totalinitial = 0;
	$totalcurrent = 0;
	$totalchange  = 0;
		
	for ($i=1; $i<count($response); $i++){
		$totalinitial += ($response[$i]['stock_owned']*$response[$i]['stock_initial']);
		$totalcurrent +=($response[$i]['stock_owned']*$response[$i]['stock_current']);
		$totalchange += ($totalcurrent - $totalinitial);
echo("

	<tr>
		<td>".$response[$i]['symbol']."</td>
		<td align=center>".$response[$i]['stock_owned']."</td>
		<td align=right>$".money_format("%i",($response[$i]['stock_owned']*$response[$i]['stock_initial']))."</td>	
		<td align=right>$".money_format("%i",($response[$i]['stock_owned']*$response[$i]['stock_current']))."</td>
		<td align=right>$".money_format("%i",($response[$i]['stock_current']-$response[$i]['stock_initial']))."</td>
			
	</tr>


");
echo("
		<td>Totals</td>
		<td align=center></td>
		<td align=right>$".money_format("%i",$totalinitial)."</td>	
		<td align=right>$".money_format("%i",$totalcurrent)."</td>	
		<td align=right>$".money_format("%i",$totalchange)."</td>	
");

}
echo("</table>");
		break;
	case 2:
		echo ("
		<header>
		<h1>User not found.</h1>
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

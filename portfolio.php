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

$request['type'] = "Portfolio";
$request['ID'] = $_SESSION['ID'];

$response = $client->send_request($request);

switch($response[0]['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
		/*
		echo ("
		<header>
		<h1>".$response['1']['symbol']."</h1></br>
		
		</header>");
		*/
echo("<table style=\"width:100%\"><tr><th>Symbol</th><th>Owned</th><th>Initial Price</th><th>Current Price</th><th>Change</th></tr>"); 

		for ($i=1; $i<count($response); $i++){
echo("

	<tr>
		<td>".$response[$i]['symbol']."</td><td align=center>".$response[$i]['stock_owned']."</td><td align=right>$".money_format("%i",($response[$i]['stock_owned']*$response[$i]['stock_initial']))."</td>	
		<td align=right>not supported</td><td align=right>not supported</td>
			
	</tr>




");
//<td>".$response[$i]['stock_current']."</td><td>".($response[$i]['stock_current']-$response[$i]['stock_initial'])."</td>

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

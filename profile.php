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


if (isset($_GET["id"])){
$client = new rabbitMQClient("rabbit/rabbit.ini","database");

$request['type'] = "Profile";
$request['ID'] = $_GET["id"];

$response = $client->send_request($request);

switch($response['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
		echo ("
		<header>
		<h1>".$response['username']."--".$response['id']."</h1></br>
		<p>".$response['fname']." ".$response['lname']."</p>
		<p> Date Joined: ".$response['date']."</p>
		</header>");
		if($_SESSION['ID'] == $_GET["id"]){
		echo("
		<form action=\"usertransactions.php\" name=\"trans\" id=\"trans\" method=\"post\">
		<input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=".$_SESSION['ID'].">
		<button id=\"trans\" name=\"trans\" type=\"sumbit\">View Transactions</button>
		</form>
		");
		}
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

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

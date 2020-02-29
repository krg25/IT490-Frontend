<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<?php include("header.php"); ?>
</head>
<body>

<div class="content">
  <div class="container">

<header>
   <h1>Stocks</h1>
</header>

  <form action="" name="login" id="login" method="post" >

  <label for="username"><b><p>Username</p></b></label>

  <input id="username" name="username" type="text" placeholder="Enter username" required> <br>

  <label for="password"><b><p>Password</p></b></label>
  <input id="password" name="password" type="password" placeholder="Enter password" required/><br>
  <br>
 <input type="submit" name="submit" id="submit">
 <br>
<br>
</form>

</div>
</div>


<?php
echo "<div name = \"phpzone\" style=\"border:1px solid gray;overflow:wrap\">";

ini_set('display_errors',1);
require_once('rabbit/path.inc');
require_once('rabbit/get_host_info.inc');
require_once('rabbit/rabbitMQLib.inc');

$client = new rabbitMQClient("rabbit/rabbit.ini","database");


if($_SERVER["REQUEST_METHOD"] == "POST"){

if (isset($_POST['username']) && isset($_POST['password']))
{
  $set = true;
  $usr = $_POST['username'];
  $pas = $_POST['password'];
	
}
else
{
  $set = false;
  echo "Please fill in both fields.".PHP_EOL;
}

if($set){
$request = array();
$request['type'] = "Login";
$request['username'] = $usr;
$request['password'] = $pas;

$response = $client->send_request($request);

switch($response['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
		echo ("Successful Login");
		$_SESSION['ID']=$response['ID'];
		$_SESSION['user']=$usr;
		header("location: /");
		die;
	case 2:
		echo ("Incorrect Login");
		break;

}//switch


}//if set


}//if post
echo "</div>".PHP_EOL;

?>
</body>
</html>

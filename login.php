<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<style>
{


}
h1 {
    color: #443366 ;
    font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;

}
p {
    color: #443366 ;
    font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;

}
body {
  background: #e6e6e6;
  text-align: center;
  }

.content {
  max-width: 500px;
  margin: auto;
  background: white;
  padding: 10px;
}
div.container {
    width: 100%;
    border: 1px solid gray;
}

header, footer {
    padding: 1em;
    color: white;
    background-color: #F08080;
    clear: left;
    text-align: center;
}
</style>
</head>
<body>

<div class="content">
  <div class="container">

<header>
   <h1>Stocks</h1>
</header>

  <form action="login.php" name="login" id="login" method="post" >

  <label for="username"><b><p>Username</p></b></label>

  <input id="username" name="username" type="text" placeholder="Enter username" required> <br>

  <label for="password"><b><p>Password</p></b></label>
  <input id="password" name="password" type="password" placeholder="Enter password" required/><br>
  <br>
 <input type="submit" name="submit">
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

if($_SERVER['REQUEST_METHOD'] == 'POST'){

if (isset($_POST["username"]) && isset($_POST["password"]))
{
  $set = true;
  $usr = $_POST["username"];
  $pas = $_POST["password"];
}
else
{
  $set = false;
  echo "Invalid arguments, proper usage: login.php <user> <pass>\n";
}

if($set){
$request = array();
$request['type'] = "Login";
$request['username'] = $usr;
$request['password'] = $pas;
$response = $client->send_request($request);



echo "client received response: ".PHP_EOL;
echo($response['message'].PHP_EOL);
echo "\n\n";

echo "END".PHP_EOL;


}


}
echo "</div>".PHP_EOL;

/* This is default code I can't use -krg
if (!isset($_POST))
{
	 $msg = "...enter your credentials. It's not optional";
	 echo json_encode($msg);
	 exit(0);
}
else
$request = $_POST;
$response = "Please leave";
switch ($request["type"])
{
	 case "login":
	 $response = "login accepted";
	 break;
}
echo json_encode($response);
exit(0);
*/
?>
</body>
</html>

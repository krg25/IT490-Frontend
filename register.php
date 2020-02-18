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
 <form name="registration" id="registration" action="" method="post">

  <label for="Username"><b><p>Username</p></b></label>
  <input id="username" name="username" type="text" placeholder="Username" required>

  <label for="password"><b><p>Password</p></b></label>
  <input id="password" name="password" type="password"  placeholder="Password" required/>

<label for="fname"><b><p>First Name</p></b></label>
  <input id="fname" name="fname" type="text" placeholder="First Name" required>

<label for="lname"><b><p>Last Name</p></b></label>
  <input id="lname" name="lname" type="text" placeholder="Last Name" required>

    <label for="email"><b><p>Email</p></b></label>
 <input id="email" name="email" type="text" placeholder="Email" name="email" required/> 
<br> 
 <input type="submit" name="submit" id="submit" >

</form>

</div>
<?php
//user_id, username, password, email first_name last_name date_joined

echo "<div name = \"phpzone\" style=\"border:1px solid gray;overflow:wrap\">";

ini_set('display_errors',1);
require_once('rabbit/path.inc');
require_once('rabbit/get_host_info.inc');
require_once('rabbit/rabbitMQLib.inc');

$client = new rabbitMQClient("rabbit/rabbit.ini","database");

if($_SERVER["REQUEST_METHOD"] == "POST"){
$errors = "";

if(!isset($_POST['username'])){
$errors = $errors."Username not entered".PHP_EOL;
}else{$usr = $_POST['username'];}
if(!isset($_POST['password'])){
$errors = $errors."Password not entered".PHP_EOL;
}else{$pas = $_POST['password'];}
if(!isset($_POST['fname'])){
$errors = $errors."First Name not entered".PHP_EOL;
}else{$fnm = $_POST['fname'];}
if(!isset($_POST['lname'])){
$errors = $errors."Last Name not entered".PHP_EOL;
}else{$lnm = $_POST['lname'];}
if(!isset($_POST['email'])){
$errors = $errors."Email not entered".PHP_EOL;
}else{$eml = $_POST['email'];}


if($errors != ""){
echo $errors;
}else{ //Valid entry
$request = array();
$request['type'] = "Register";
$request['username'] = $usr;
$request['password'] = $pas;
$request['fname'] = $fnm;
$request['lname'] = $lnm;
$request['email'] = $eml;

$response = $client->send_request($request);

switch($response['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
		echo ("Successful Registration");
		session_start();
		$_SESSION['user']=$usr;
		header("location: /");
		die;
	case 2:
		echo ("Sum ding wong");
		break;

}//switch

}//if errors

}//if post


/*
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$request = array();
$request['type'] = 'register_user';
$request['username'] = $_GET['username'];
//$request['password'] = $_GET['password'];
$mypassword = $_GET['password'];
$request['password'] = md5($mypassword);
$request['email'] = $_GET['email'];
$_SESSION['email'] = $_GET['email'];

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
$response = $client->send_request($request);

if($response==1){
	$registrationSuccess = "good";
} else {
	$registrationSuccess = "MESSAGE FAIL";
}

if($registrationSuccess=="MESSAGE FAIL"){
	echo "yup";
        $client = new rabbitMQClient("testRabbitMQ_Backup.ini","testServer");
        $response = $client->send_request($request);
}
*/

?>
</body>
</html>


<!DOCTYPE html>
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

<main class="register-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                         <form name="registration" id="registration" action="" method="post">
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-6">
                                    <input type="text" id="username" class="form-control" name="username" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                </div>
                            </div>

							<div class="form-group row">
                                <label for="fname" class="col-md-4 col-form-label text-md-right">First Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="fname" class="form-control" name="fname" required autofocus>
                                </div>
                            </div>

							<div class="form-group row">
                                <label for="lname" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="lname" class="form-control" name="lname" required autofocus>
                                </div>
                            </div>

							<div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input type="text" id="email" class="form-control" name="email" required autofocus>
                                </div>
                            </div>
						
							<div class="col-md-6 offset-md-4">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">
                                    Register
                                </button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
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
		$_SESSION['ID']=$response['ID'];
		$_SESSION['user']=$usr;
		echo ($_SESSION['ID']);
		echo "<script type='text/javascript'>window.top.location='/index.php';</script>"; exit;
		//header("Location: /index.php", true, 301); exit;

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


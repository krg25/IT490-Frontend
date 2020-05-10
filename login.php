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
<?php
        include("header.php");
    ?>
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Log In</div>
                    <div class="card-body">
                        <form action="" method="">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email-address" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Log In
                                </button>
                                <a href="#" class="btn btn-link">
                                    Forgot Your Password?
                                </a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>	
	
<!--
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
-->

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

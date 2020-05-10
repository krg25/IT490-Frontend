<!---Kenneth Gronemann, Professor Deek IT202-452, Assignment 5--->
<!DOCTYPE html>
<html>
<head>
<title>Kenchat</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type = "text/javascript" src = "js/lookup.js"></script>
</head>
<body>
<?php include("header.php"); ?>

	<h2>Kenchat</h2>
<?php
	echo "<p>Currently logged in as: ";
	if (isset($_SESSION['user'])){
	echo $_SESSION['user']." ".$_SESSION['ID'];
	}else{ echo "NULL "; }
	echo "</p>";

?>
   <table>
	<tr>
	<td valign="top">
   <div class="container">  
   <form id="lookup" action="kenchat.php" method="post">
	<fieldset>
		<textarea style="resize:none;" id="chat" name="chat" placeholder="Say hi!" type="textarea" maxlength="128" rows="5" cols="30" tabindex="3" required value=""></textarea>
    </fieldset>
	<fieldset>
      <input name="submit" type="submit" value="Submit" />
    </fieldset>
   </form>
   </div>
   
<?php
echo "<div name = \"phpzone\" style=\"border:1px solid gray;max-width:256px;overflow:wrap\"> ";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

$errors = array();
if(isset($_SESSION['user'])){
	$errors[] = 'No name';
}else{$name = $_SESSION['user'];}

if(empty($_POST['chat'])){
	$errors[] = 'No chat';
}else{$chat = ($_POST['chat']);}

if (empty($errors)){
require_once('rabbit/path.inc');
require_once('rabbit/get_host_info.inc');
require_once('rabbit/rabbitMQLib.inc');

$client = new rabbitMQClient("rabbit/rabbit.ini","database");

$request = array();
$request['type'] = "InsertChat";
$request['username'] = $name;
$request['content'] = $chat;

$response = $client->send_request($request);

switch($response['returnCode']){
	case 0:
		echo ("Server error, please retry");
		break;
	case 1:
		echo ("Chat Sent Successfully");
		break;
	case 2:
		echo ("Input Error");
		break;

}//switch



//Construct rabbit message with username, and chat message

//Move this all to database
/*
	require('mysqli_connect.php');
	$timestamp = date('Y-m-d G:i:s'); //timestamp for the table

	$name = mysqli_real_escape_string($dbc, $name); //this function allows for the safe entry of special characters to the table
	$chat = mysqli_real_escape_string($dbc, $chat);

	$q = "SELECT username FROM users_table WHERE (username='$name')"; //check for the user in user table
	$r = @mysqli_query($dbc, $q);
	$num = @mysqli_num_rows($r);

//KRG490 This is basically cool, chat_log needs to be created	

	if($num==1){ //user is verified, enter post into chat log
		$q = "INSERT INTO chat_log (username, content, timestamp) VALUES ('$name', '$chat', '$timestamp')";
		$r = @mysqli_query($dbc, $q);
		if (empty(mysqli_error($dbc))){
			echo "post submitted...<br/>";
		}else{
			echo "error: " . mysqli_error($dbc);
		}
	}else{echo "login failed.";}
	mysqli_close($dbc); //VERY important!
*/
}//close if empty errors
	else{foreach($errors as $msg){echo $msg;}}

}//end submit
echo "</div>";
?>
</td>
<td valign="top">
   <div name="chatbox" id="chatbox" style="border:1px solid gray;overflow:scroll;line-height:1em;height:256px;overflow-x:hidden;overflow-y:hidden;" >
		<!---This is my actual chatbox, entries are filled in from the lookup.js file (named when I was expirimenting)--->
   </div>
</td>
   </table>
</body>
</html>

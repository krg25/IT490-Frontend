<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<script type="text/php" src="testRabbitMQClient.php"> </script>
<?php include("header.php"); ?>
</head>
<body>

<div class="content">
  <div class="container">

<header>
   <h1>Stocks</h1>
</header>
<?php
session_start();
if (!isset($_SESSION['user'])){
  echo ("<a href = login.php>Login Here</a>");
}
else
{
 echo ("Welcome ".$_SESSION['user']);
}
?>
</div>
</body>
</html>

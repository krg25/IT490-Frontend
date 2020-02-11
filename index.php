<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<script type="text/php" src="testRabbitMQClient.php"> </script>
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

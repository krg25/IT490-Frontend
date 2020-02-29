
<link rel="stylesheet" type="text/css" href="style.css">
   <div class="topnav">
      <!-- navbar -->
      <a href=/>Home</a>
      <a href=stocks.php>Markets</a>
<?php
session_start();
if (!isset($_SESSION['user'])){
echo("
        <a href=login.php>Log In</a>
        <a href=register.php>Sign Up</a>
");
}else{
echo("
      <a href=profile.php?id=".$_SESSION['ID'].">Profile</a>
      <a href=portfolio.php>My Portfolio</a>
      <a href=logout.php>Logout</a>
");
}
?>
     <!-- <div class="search-container"> I don't like it.-->
        <form action='search.php'>
          <input type='text' placeholder='Search..' name='search'>
        </form>
	</div>
    <!-- </div> -->

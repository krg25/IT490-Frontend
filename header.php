
<link rel="stylesheet" type="text/css" href="style.css">
<!-- essentially the navbar --> 
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href=index.php>Stocks</a> 

    <!-- button for mobile view -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=#navbarSupportedContent aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href=stocks.php>News<span class="sr-only">(current)</span></a>
            </li>
    
<?php
	session_start();
	if (!isset($_SESSION['user'])){
		echo("
			<li class=\"nav-item\">   
			    <a class=\"nav-link\" href=login.php>Log In</a>
			</li>
			<li class=\"nav-item\">
			    <a class=\"nav-link\" href=register.php>Sign Up</a>
			</li>

	");
	}else{
		echo("
			<li class=\"nav-item\">       
			    <a class=\"nav-link\" href=profile.php?id=".$_SESSION['ID'].">Profile</a>
			<\li>
			<li class=\"nav-item\">
			    <a class=\"nav-link\" href=portfolio.php>My Portfolio</a>
			<\li>
			<li class=\"nav-item\">
			    <a class=\"nav-link\" href=chat/kenchat.php>Chat</a>
			</li>
			<li class=\"nav-item\">
			    <a class=\"nav-link\" href=logout.php>Logout</a>
			</li>
			<li class=\"nav-item\">
			    <a class=\"nav-link\" href=chat/kenchat.php>Chat</a>
			</li>
           ");
        }

	?>
	</ul>
        <form class="form-inline my-2 my-lg-0" action='search.php'>
          <input class="form-control mr-sm-2" type='search' placeholder='Search..' aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

	</div>
</nav>

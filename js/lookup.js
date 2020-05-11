$(function(){ //This runs when the page is loaded
	setTimeout(listen(), 10000);
});

function listen(){ //Beautiful AJAX the great, son of Telamon, bulwark of the Akhaians...
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		
    if (this.readyState == 4 && this.status == 200) {
		document.getElementById("chatbox").innerHTML = this.responseText; //Fill chatbox with PHP response! This works, imagine my surprise.
		setTimeout(listen(), 10000);
		var element = document.getElementById("chatbox");
		element.scrollTop = element.scrollHeight;
    }
	};//function
  
  xhttp.open("GET", "getchat.php", true);
  xhttp.send();
}

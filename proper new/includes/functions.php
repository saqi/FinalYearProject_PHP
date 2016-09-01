<?php 
// redirect to index page
function toindex(){
header("Location: index.php");
}

function toproducts() {
header("Location: products.php");
}

function tofile(){
header("Location: file.php");
}

// If user is logged in returns true
function loggedin(){
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
	return true;
} // end of if statement
else {return False;}
} // end of function

//If session message set then echo message and unset var
function rmessage(){
		if(isset($_SESSION['rmessage'])){
		echo "<div id='rmessage' class='message'><p>". $_SESSION['rmessage']."</p></div>";
		unset($_SESSION['rmessage']);
		}
}
function amessage(){
		if(isset($_SESSION['amessage'])){
		echo "<div id='amessage' class='message'><p>". $_SESSION['amessage']."</p></div>";
		unset($_SESSION['amessage']);
		}
}
?>
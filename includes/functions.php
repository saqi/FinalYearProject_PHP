<?php 
// redirect to index page
function toindex(){
header("Location: login.php");
}
function tologin(){
header("Location: login.php");
}

function toproducts() {
header("Location: products.php");
}

function todailys() {
header("Location: dailys.php");
}
function toview(){
header("Location: view.php");
}
function toaccount() {
header("Location: account.php");
}


function toabout(){
header("Location: about.php");
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
		if(isset($_SESSION['rmessage']) && $_SESSION['rmessage'] != ''){
		echo "<div id='rmessage' class='message'><p>". $_SESSION['rmessage']."</p></div><br />";
		unset($_SESSION['rmessage']);
		}
}
function amessage(){
		if(isset($_SESSION['amessage']) && $_SESSION['amessage'] != ''){
		echo "<div id='amessage' class='message'><p>". $_SESSION['amessage']."</p></div><br />";
		unset($_SESSION['amessage']);
		}
}
?>
<?php  session_start();
ob_start();
require_once("includes/connection.php"); 
require_once("includes/functions.php");  

// SESSION VARIABLES

if (loggedin()){
$amessage = "You have already logged in, no need to try to login again :-)";
$_SESSION['amessage'] = $amessage;
toproducts();
} else {
$_SESSION['loggedin'] = '';
$_SESSION['username'] = '';
$_SESSION['userid'] = '';
$_SESSION['amessage'] = '';
}

?>
<html>
	<head>
		<title>Login</title>
		<!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster+Two" />
        <link rel="stylesheet" href="assets/jquery.pointpoint/jquery.pointpoint.css" /> 
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script type='text/javascript' src='menu_jquery.js'></script>
  <script>
  $(function() {
    $( "button" )
      .button()
      .click(function( event ) {
/*         event.preventDefault(); */
      });
	  
	  $( ".message" ).click(function() {
  $( ".message" ).fadeOut( "slow" );
});
  });
  </script>
	</head>
	<body>
	
	<div id="body">
	<!-- top banner -->
	<div id="banner">
	<img id="banner1" src="Banner.png" alt="Retail Portal">
	</div>
	
	<!-- navigation 
	<div id='cssmenu'>
	<ul>
	   <li class='active'><a href='products.php'><span>PRODUCT SALES <br />&amp; CHARTS</span></a></li>
	   <li><a href='dailys.php'><span>DAILY SALES<br /> &amp; CHARTS</span></a></li>
	   <li><a href='view.php'><span>VIEW, ADD &amp;<br /> EDIT PRODUCTS</span></a></li>
	   <li class='last'><a href='account.php'><span>ACCOUNT <br />SETTINGS</span></a></li>
	</ul>
	</div><!-- end of nav div -->
		
<?php
rmessage();		
?>
		
		<div id="login" class="form-container">
		
		<form  action="login.php" method="post" >		
		Username   
		<br /> <input type="text" placeholder="Username not E-mail" name="lusername" class="form-field" autofocus> <br />
		Password   
		<br /> <input class="form-field" type="password" name="password"> <br />
		<span class="submit-container">
		<input type="submit" class="submit-button" name="lsubmit" value="Login" />
		</span>
		
		<a href='fpass.php'><button type="button" class="fpassword">Forgot your password?</button></a>
		
		</form>
		</div>

		
		
		
	<div id="footer"><a href="about.php">
	<img id="footer1" src="footer11.png" alt="Retail Portal"></a>
	</div>
		
	</div> <!-- body container div -->
	
	<!-- Including the PointPoint() Plugin -->
		<script src="assets/jquery.pointpoint/transform.js"></script>
		<script src="assets/jquery.pointpoint/jquery.pointpoint.js"></script>
		
		<!-- The main script file -->
        <script src="assets/js/script.js"></script>
	
	</body>
</html>
<?php
$erors = array();// set an empty array that will contains the errors
if(isset($_POST['lsubmit']) && isset($_POST['lusername']) && isset($_POST['password'])){ //logging in users
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$lusername = $connection->real_escape_string($_POST['lusername']);
$password = $connection->real_escape_string($_POST['password']);
if (strlen($_POST['lusername'])<3) {$erors[] = 'Userame must contain minimum 3 characters';}
if (strlen($_POST['password'])<6) {$erors[] = 'Password must contain minimum 6 characters';}

$query = "SELECT * 
FROM  `user` 
WHERE  `Username` =  '".$lusername."'";
if ($numUsers = $connection->query($query)){
if ($numUsers->num_rows < 1){ $erors[] = "No such user has been registered, pls register or try a different username";
}
while ($user = $numUsers->fetch_assoc()){
$password = hash('sha1',$password);
if ($password != $user['hashed_password']){
$erors[] = "The password you typed wasn't correct";
} // if passwords don't match
} // end of while
} // if user(s) found
if (count($erors)< 1){ // if no errors
$_SESSION['loggedin'] = true;
$_SESSION['username'] = $lusername;

$idquery = "SELECT `User_ID` FROM  `user` WHERE  `Username` =  '".$lusername."'";
if ($Userid = $connection->query($idquery)){
	if ($Userid->num_rows < 2 && $Userid->num_rows > 0){
		while($idrow = $Userid->fetch_assoc()) {
			$_SESSION['userid'] = $idrow['User_ID'];
		}
	} // if Userid has only 1 match of Username (end)
} // end of selecting user_id with username match

$amessage = "User Logged in!";
$_SESSION['amessage'] = $amessage;
toproducts();
} // if no errors
else { // there r errors
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
tologin();
exit();
}
} // loggin in users end if form is submitted
?>
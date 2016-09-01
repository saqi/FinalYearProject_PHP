<?php	session_start();
ob_start();
require_once("includes/connection.php");
require_once("includes/functions.php");

// SESSION VARIABLES

 if (!loggedin()){
$rmessage = "You must be logged in to use this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}
?>

<html>
	<head>
		<title>VIEW, ADD &amp; EDIT PRODUCTS</title>
		
		<!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster+Two" />
        <link rel="stylesheet" href="assets/jquery.pointpoint/jquery.pointpoint.css" /> 
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		
		<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type='text/javascript' src='menu_jquery.js'></script>
		<script>
  $(function() {
    $( "#logdiv button, input[type=submit]" )
      .button()
      .click(function( event ) {
/*         event.preventDefault(); */
      });
	  
	$( ".message" ).click(function() {
  $( ".message" ).fadeOut( "slow" );
});
  });
  </script>
		<script>
		$(document).ready(function() {

		// Bind click events on buttons to trigger specified functions

		$('#button').bind('click',postToPage);

		$('#vtpsubmit').bind('click',gettop);

		function postToPage() {
		$('#chart1').load("getuser.php");
		}

		function gettop() {
		$('#chart1').load("fileb.php");
		}
		});
		</script>
	</head>
	<body>

	<div id="body">
	<!-- top banner -->
	<div id="banner">
	<img id="banner1" src="Banner.png" alt="Retail Portal">
	</div>
	
	<div id='cssmenu'>
	<ul>
	   <li><a href='products.php'><span>PRODUCT SALES <br />&amp; CHARTS</span></a></li>
	   <li><a href='dailys.php'><span>DAILY SALES<br /> &amp; CHARTS</span></a></li>
	   <li class='active'><a href='view.php'><span>VIEW, ADD &amp;<br /> EDIT PRODUCTS</span></a></li>
	   <li class='last'><a href='account.php'><span>ACCOUNT <br />SETTINGS</span></a></li>
	</ul>
	</div><!-- end of nav div -->
	
<?php
rmessage();
amessage();
?>	
	
	<br /><br />
	<div id="logdiv"> 
<?php
if (loggedin()){
echo "<a href='logout.php'><button type='button'> Logout</button></a>";
}
?>	
	</div>

		<h3 id="viewh3">Adding an ISBN that already exists will update the other parts of the product</h3>
		
		<div id="anproducts" class="form-container1">
		<form id="anpform" action='view.php' method='post'>
		<table><tbody>
		<tr>
		<th colspan="2">Add new Products </th>
		</tr>
		<tr>
		<td>ISBN:</td>
		<td><input type="text" name="isbn1" class="form-field1" autofocus> </td>
		</tr>
		<tr>
		<td>Product name:</td>
		<td><input type="text" name="proname" class="form-field1" > </td>
		</tr>
		<tr>
		<td>Dimensions:</td>
		<td><input type="text" class="form-field1" name="dimensions"> </td>
		</tr>
		<tr>
		<td>Selling price:</td>
		<td><input type="text" class="form-field1" name="sprice"> </td>
		</tr>
		<tr>
		<td>Weight:</td>
		<td><input type="text" class="form-field1" name="weight"> </td>
		</tr>
		<tr>
		<td>Code:</td>
		<td><input type="text" class="form-field1" name="code"> </td>
		</tr>
		<tr>
		<td colspan="2"><input type="submit" name="anpsubmit" value="Add" class="submit-button1" /></td>
		</tr></tbody></table>

		</form>
		</div> <!-- add new products div -->
		
		
		<div class="vpdivs1">
		<h2>View Products</h2>
		
		<div id="products" class="form-container1">		
		<form id="pform" method='post'>
		<table><tbody>
		<tr>
		<th>Show all Products</th>
		</tr>
		<tr>
		<td colspan="2"><button type="button" id="button" class="submit-button1">Get Products</button></td>
		</tr>
		</tbody></table>
		</form>
		</div>

		<div id="vtproducts" class="form-container1">
		<form id="vtpform" method='post'>
		<table><tbody>
		<tr><th colspan="2">View top 3 Products </th></tr>
		
		<tr>
		<td colspan="2"><button type="button" id="vtpsubmit" class="submit-button1">View top Products</button></td>
		</tr>
		</tbody></table>
		</form>
		</div> <!-- view top products div -->

		<div id="chart1" class="CSSTable"> </div>

		</div>
		
		<br />
		
		
<?php // code for adding new products
$erors = array();// set an empty array that will contains the errors
$update = array(); // an empty array if isbn already exists to update

if(isset($_POST['anpsubmit'])){ //logging in users
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);

$isbn1 = $connection->real_escape_string($_POST['isbn1']);
$proname = $connection->real_escape_string($_POST['proname']);
$dimensions = $connection->real_escape_string($_POST['dimensions']);
$sprice = $connection->real_escape_string($_POST['sprice']);
$weight = $connection->real_escape_string($_POST['weight']);
$code = $connection->real_escape_string($_POST['code']);
$userid = $_SESSION['userid'];

settype($sprice, "double");
settype($code, "integer");
settype($proname, "string");
settype($dimensions, "varchar");
settype($weight, "string");

/*
if ( $sprice == 0 || gettype($sprice) != "double") {
$erors[] = "Enter Numbers only PLS!!";
}
*/

if ( $isbn1 == 0 || strlen($isbn1) != 13) {
$erors[] = "ISBN must only 13 numbers!!";
}// 13 numbers in isbn entered

// if isbn already in products table
$existquery = "SELECT * FROM  `products` WHERE  `ISBN` = {$isbn1}";
$exist = $connection->query($existquery);
if ($exist->num_rows > 0){
$update[] = "This ISBN is in the products table!!";
}

if ( gettype($code) != "integer")
$erors[] = "Enter Numbers only PLS!!";

$num_length = strlen((string)$code);
if($num_length != 5) {
$erors[] = "Code can only be 5 numbers long!!";
}

// if code already in products table
$existquery1 = "SELECT * FROM  `products` WHERE  `code` = {$code} AND `ISBN` != {$isbn1}";
$exist1 = $connection->query($existquery1);
if ($exist1->num_rows > 0){
$erors[] = "This code is already associated with another ISBN!!<br /> 
Enter a new code.";
}

 if (count($update) > 0){ // product needs to be updated instead of insert query
$uquery = "UPDATE `products` SET `product_name`= '{$proname}',`dimensions`= '{$dimensions}',`selling_price`= {$sprice},`weight`= '{$weight}',`code`= {$code},`User_ID`= {$userid} WHERE `ISBN`= {$isbn1};";
if (!$uquery1 = $connection->query($uquery)) {
$erors[] = $connection->sqlstate;
$amessage =  "'".$connection->sqlstate."'";
$_SESSION['amessage'] = $amessage;
toview();
}
else {
$amessage = 'product updated';
$_SESSION['amessage'] = $amessage;
toview();
}
}

if (count($erors) < 1 && count($update) < 1){ // if no errors or update
$iquery1 = "INSERT INTO `products`(`ISBN`, `product_name`, `dimensions`, `selling_price`, `weight`, `code`, `User_ID`) VALUES ({$isbn1}, '{$proname}','{$dimensions}',{$sprice},'{$weight}',{$code},{$userid})";

if (!$insert1 = $connection->query($iquery1)){
$amessage =  "'".$connection->sqlstate."'";
$_SESSION['amessage'] = $amessage;
toview();
} else {
$amessage = 'New Product inserted in database';
$_SESSION['amessage'] = $amessage;
}

} // if no errors



else { //errors!!!
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toview();
}

/* $amessage = implode('<br />', $update);
$_session['amessage'] = $amessage; */
toview();
} //post for adding new products

?>
	

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
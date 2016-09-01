<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");

// SESSION VARIABLES

 if (!loggedin()){
$rmessage = "You must be logged in to use this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}
$userid = $_SESSION['userid'];
?>

<html>
	<head>
		<title>PRODUCT SALES &amp; CHARTS</title>
		<!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster+Two" />
        <link rel="stylesheet" href="assets/jquery.pointpoint/jquery.pointpoint.css" /> 
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
				

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type='text/javascript' src='menu_jquery.js'></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
		
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
	
	<div id='cssmenu'>
	<ul>
	   <li class='active'><a href='products.php'><span>PRODUCT SALES <br />&amp; CHARTS</span></a></li>
	   <li><a href='dailys.php'><span>DAILY SALES<br /> &amp; CHARTS</span></a></li>
	   <li><a href='view.php'><span>VIEW, ADD &amp;<br /> EDIT PRODUCTS</span></a></li>
	   <li class='last'><a href='account.php'><span>ACCOUNT <br />SETTINGS</span></a></li>
	</ul>
	</div><!-- end of nav div -->
<?php
amessage();
rmessage();
?>	
	<br /><br />
	<div id="logdiv"> 
<?php
if (loggedin()){
echo "<a href='logout.php'><button type='button'> Logout</button></a>";

}
?>	
	</div>
	
	<!-- add product sales -->
	<div class="form-container1" id="apdiv">
	<form id="apform" action='products.php' method='post'>
	<table><tbody>
	<tr><th colspan="2">Product Sale</th></tr> 
	<tr><td>ISBN:</td>
		<td><input type='text' name='isbn' class="form-field1" autofocus /></td>
	</tr>
	
	<tr><td>Quantity:</td>
		<td><input type='text' class="form-field1" name='quantity' value="1"></td>
	</tr>
	
	<tr><td colspan="2"><input type='submit' name='psubmit' value='Submit' class="submit-button1" /></td></tr>
	</tbody></table>
	</form>
	</div> <!-- apdiv ends here -->

	
<?php // code for adding product sales

if(isset($_POST['psubmit']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$isbn = $connection->real_escape_string($_POST['isbn']);
$quantity = $connection->real_escape_string($_POST['quantity']);
settype($quantity, "integer"); 	

if ( $isbn == 0 || strlen($isbn) != 13) {
$erors[] = "ISBN cannot be less or greater than 13!!";
}// 13 numbers in isbn entered

if(gettype($quantity) != "integer") {
$erors[] = "Enter Numbers only for Quantity.";
} // quantity is not null or letters

if($quantity == 0 || gettype($quantity) != "integer" || $quantity > 100) {
$erors[] = "Enter Numbers greater than 0  for quantity. <br /> Quanity cannot exceed 100.";
} // quantity is not null or letters

// if isbn doesn't exist in products table
$existquery = "SELECT * FROM  `products` WHERE  `ISBN` = {$isbn}";
$exist = $connection->query($existquery);
if ($exist->num_rows < 1){
$erors[] = "Not a valid ISBN!!<br /> re-enter ISBN or add it.";
}

if (count($erors) <1){
$time = time();
$cyear = strftime("%Y",$time);
$cmonth = strftime("%m",$time);
$cday = strftime("%d",$time);
$date = settype($cday, 'string')."//".settype($cmonth, 'string')."//".settype($cyear, 'string');

$iquery = "INSERT INTO `product_sales`(`ISBN`, `quantity_sold`, `day`, `month`, `year`, `date`, `User_ID`) VALUES ({$isbn}, {$quantity},  {$cday}, {$cmonth}, {$cyear}, concat(`day`, '/', `month`, '/', `year`), {$userid});";
$insert = $connection->query($iquery);

$amessage = 'Product Sale added.';
$_SESSION['amessage'] = $amessage;
toproducts();
} // if errors are less than one

else { // there are errors
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toproducts();
}

} // psubmit (product submit) post end

?>

	<div class="vpdivs">
	
	<h2>View chart for products</h2>
	
	<div id="vcproducts" class="form-container1"> <!-- view chart products -->
	<form id="vcpform" action="filegraph2.php" method='post' >
	<table><tbody>
	<tr><th colspan="2">View chart for Product By ISBN</th></tr>
	<tr>
	<td>ISBN:</td>
	<td><input type="text" name="isbn2" class="form-field1"></td>
	</tr>
	<tr>
	<td>Year:</td>
	<td><select name="years2">
<?php
$yearsh2 = $connection->query("SELECT DISTINCT `year` FROM `product_sales`");
while ($year = $yearsh2->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
	</select> </td>
	</tr>
	
	<tr><td colspan="2"><input type="submit" name="vcisubmit" value="View" class="submit-button1" /></td></tr>
	</tbody></table>
	</form>
	<br />
	</div> <!-- view chart products div -->

	<!-- view chart for product by code -->
	<div id="vcproducts2" class="form-container1">
	<form id="vcpform2" method='post' action="filegraph2.php">
	<table><tbody>
	<tr><th colspan="2">View chart for Product By Code</th></tr>
	<tr>
	<td>Code: </td>
	<td><input type="text" name="code2" class="form-field1"> </td>
	</tr>
	<tr>
	<td>Year:</td>
	<td><select name="years3">
<?php
$yearsh3 = $connection->query("SELECT DISTINCT `year` FROM `product_sales`");
while ($year = $yearsh3->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
	</select></td>
	</tr>
	<tr><td colspan="2"><input type="submit" name="vccsubmit" value="View" class="submit-button1"/></td></tr>
	</tbody></table>
	</form>
	<br />
	</div>
	
	</div> <!-- view product divs div -->
	
	
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
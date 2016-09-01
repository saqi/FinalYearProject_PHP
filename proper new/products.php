<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");
include('includes/graidlechart/graidle.php');
include_once("includes/phpMyGraph5.0.php");

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
		<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="dist/jquery.jqplot.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>

<script>
$(document).ready(function() {

// Bind click events on buttons to trigger specified functions

$('#button').bind('click',postToPage);

$('#vtpsubmit').bind('click',gettop);

function postToPage() {
$('#txtHint').load("getuser.php");
}

function gettop() {
$('#chart1').load("fileb.php");
}

});
</script>

<link rel="stylesheet" type="text/css" href="dist/jquery.jqplot.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
	
	<!-- add product sales -->
	<div id="apdiv">
	<form id="apform" action='products.php' method='post'>
	Product Sale<br /> ISBN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='text' name='isbn'><br />
	Quantity: &nbsp;&nbsp;<input type='text' name='quantity' value="1"><br />
	<input type='submit' name='psubmit' value='Submit' />
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

if($quantity == 0 || gettype($quantity) != "integer" || $quantity > 100) {
$erors[] = "Enter Numbers only for quantity!! <br /> Quanity cannot exceed 100 either.";
} // quantity is not null or letters

// if isbn doesn't exist in products table
$existquery = "SELECT * FROM  `product_sales` WHERE  `ISBN` = {$isbn}";
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

$iquery = "INSERT INTO `product_sales`(`ISBN`, `quantity_sold`, `day`, `month`, `year`, `date`, `User_ID`) VALUES ({$isbn}, {$quantity},  {$cday}, {$cmonth}, {$cyear}, concat(`day`, '/', `month`, '/', `year`), '1');";
$insert = $connection->query($iquery);

} // if errors are less than one

else { // there are errors
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toproducts();
}

} // psubmit (product submit) post end

?>

<div id="vcproducts"> <!-- view chart products -->
<form id="vcpform" action="filegraph2.php" method='post' >
View chart for Product By ISBN<br />
ISBN: <input type="text" name="isbn2"> <br />
Year:
<select name="years2">
<?php
$yearsh2 = $connection->query("SELECT DISTINCT `year` FROM `product_sales`");
while ($year = $yearsh2->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
</select> <br />
<input type="submit" name="vcisubmit" value="View" />
</form>
<br />
</div> <!-- view chart products div -->

<!-- view chart for product by code -->
<form id="vcpform2" method='post' action="filegraph2.php">
View chart for Product By Code<br />
Code: <input type="text" name="code2"> <br />
Year:
<select name="years3">
<?php
$yearsh3 = $connection->query("SELECT DISTINCT `year` FROM `product_sales`");
while ($year = $yearsh3->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
</select> <br />
<input type="submit" name="vccsubmit" value="View" />
</form>

<?php
echo $rmessage;
?>

</body>
</html>
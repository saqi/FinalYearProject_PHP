<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");
include('includes/graidlechart/graidle.php');
include_once("includes/phpMyGraph5.0.php");

// SESSION VARIABLES

if (!loggedin() || $_SESSION['username'] != 'saqalain'){
$rmessage = "You must be logged in or be Saqalain to come to this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}
?>

<html>
	<head>
		<title>File</title>
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
	<h1 id='fileh1'>Add sales figure for today</h1>
	<h3><a href="index.php">Back to Homepage</a></h3>
	<div id="afdiv">
	<form id="asform" action='file.php' method='post'>
	Sales for Today: £
	<input type='text' name='wtf'><br />
	<input type='submit' name='submit' value='Submit' />
	</form>
	</div>

	<!-- add products -->
	<div id="apdiv">
	<form id="apform" action='file.php' method='post'>
	Product Sale<br /> ISBN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='text' name='isbn'><br />
	Quantity: &nbsp;&nbsp;<input type='text' name='quantity' value="1"><br />
	<input type='submit' name='psubmit' value='Submit' />
	</form>
	</div>
	

<?php
rmessage();
$erors = array();// set an empty array that will contains the errors
// for adding new sales data
if(isset($_POST['submit']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$wtf = $connection->real_escape_string($_POST['wtf']);
settype($wtf, "double");

if ( $wtf == 0 || gettype($wtf) != "double") {
$erors[] = "Enter Numbers only PLS!!";
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toindex();
} else { // only float entered

$time = time();
$cyear = strftime("%Y",$time);
$cmonth = strftime("%m",$time);
$cday = strftime("%d",$time);
$date = settype($cday, 'string')."//".settype($cmonth, 'string')."//".settype($cyear, 'string');

// check if date already exists & update
$query = "Select * FROM `tSales` WHERE `day` = {$cday} AND `month` = {$cmonth} AND `year` = {$cyear};";
$rexists = $connection->query($query);
if ($rexists->num_rows > 0){
$update = $connection->query("UPDATE `tSales` SET `amount` = {$wtf} WHERE `day` = {$cday} AND `month` = {$cmonth} AND `year` = {$cyear};");
}
else { // new amount entry
$iquery = "INSERT INTO `tSales`(`amount`, `day`, `month`, `year`, `date`) VALUES ({$wtf},  {$cday}, {$cmonth}, {$cyear}, concat(`day`, '/', `month`, '/', `year`));";
$insert = $connection->query($iquery);
} // else new entry
} // only float entered
} // post is set
/*
if (is_dir($cyear)){ // if folder [year] exists
chdir($cyear); 

if (is_file($cmonth)){ // if file [month] exists
if ($handle = fopen($cmonth.'.txt','a+') ){// handle
	fwrite($handle, $cday.': '.$wtf."\n"); 
} // handle file open & write to file
} // if file  [month] exists

else { // [year] exists but not [month]
if ($handle = fopen($cmonth.'.txt','a+') ){
	fwrite($handle, $cday.': '.$wtf."\n"); 
} // handle file open
} // [year] exists but not [month]
} // if folder [year] exists

else { // folder [year] doesn't exist
mkdir($cyear);
chdir($cyear); 
if ($handle = fopen($cmonth.'.txt','a+') ){
	fwrite($handle, $cday.': '.$wtf."\n"); 
} // handle file open & write to file
} // folder [year] doesn't exist
} // only float entered
} // Post is set (Writing to files in folder!
*/

// for adding product data
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
$existquery = "SELECT * FROM  `psales` WHERE  `ISBN` = {$isbn}";
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

$iquery = "INSERT INTO `psales`(`ISBN`, `quantity sold`, `day`, `month`, `year`, `date`) VALUES ({$isbn}, {$quantity},  {$cday}, {$cmonth}, {$cyear}, concat(`day`, '/', `month`, '/', `year`));";
$insert = $connection->query($iquery);

} // if errors are less than one

else { // there are errors
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toindex();
}

} // psubmit (product submit) post end
?>
<br /><br />
<div id="totals">
<h3>View Totals</h3>
<form action='file.php' method='post'>
View total sales in Year:
<select name="years">
<?php
$yearsh = $connection->query("SELECT DISTINCT `year` FROM `tsales`");
while ($year = $yearsh->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
</select> <br />

View total sales by Month:
<select name="months">
<option value="">All Months</option>
<?php
$monthsh = $connection->query("SELECT DISTINCT `month` FROM `tsales`");
while ($month = $monthsh->fetch_assoc()){
		echo '<option value="'.$month['month'].'">'.$month['month']."</option>";
	}
?>
</select> <br />
<input type="submit" name="tsubmit" value="Submit" />
</form>

<?php
//View total sales (numerical) code
if(isset($_POST['tsubmit']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$years = $connection->real_escape_string($_POST['years']);
$months= '';
// if month is set
if ($_POST['months'] != ''){
$months = "AND `month` = '".$_POST['months']."';";
}

$tquery = "SELECT SUM(`amount`) AS am FROM `tsales` WHERE `year` = '". $_POST['years']."' ".$months;

$tview = $connection->query($tquery);

while ($tview1 = $tview->fetch_assoc()){
echo "<div><h1>".$tview1['am']."</h1></div>";
}

} // post is set

// Array of Graph name and values
$graphs = array("Simple vertical column graph" => "parseVerticalSimpleColumnGraph", "Vertical line graph" => "parseVerticalLineGraph", "Vertical shadow column graph" => "parseVerticalColumnGraph", "Vertical polygon graph" => "parseVerticalPolygonGraph", "Simple horizontal column graph" => "parseHorizontalSimpleColumnGraph", "Horizontal line graph" => "parseHorizontalLineGraph", "Horizontal shadow column graph" => "parseHorizontalColumnGraph", "Horizontal polygon graph" => "parseHorizontalPolygonGraph");

?>

 <form id="afform" action='filegraph.php' method='post'>

View sales by months graph <br />
Year: <select name="years">
<?php
$yearsh = $connection->query("SELECT DISTINCT `year` FROM `tsales`");
while ($year = $yearsh->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
</select> <br />
Type of Graph: <select name="graphs">
<?php
foreach($graphs as $key => $value){
	echo '<option value="'.$value.'">'.$key."</option>";
}
?>
</select> <br />
<input type="submit" name="vsubmit" value="View" />
</form>
<br />
<form id="afform9" action='filegraph1.php' method='post'>
<div class="hidden1">
View sales by months graph <br />
Year: <select name="years">
<?php
$yearsh = $connection->query("SELECT DISTINCT `year` FROM `tsales`");
while ($year = $yearsh->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
</select> <br />
Type of Graph: <select name="graphs">
<?php
foreach($graphs as $key => $value){
	echo '<option value="'.$value.'">'.$key."</option>";
}
?>
</select> <br />
</div> <!-- hidden div -->
<input type="submit" name="vsubmit1" value="Save as Image" />
</form>
</div>

<div id="products">
<h3>Products</h3>

<form id="pform" method='post'>
Show all Products
<button type="button" id="button">Get Products</button>
</form>
<div id="txtHint"></div>
</div>


<div id="anproducts">
<form id="anpform" action='filea.php' method='post'>
Add new Products <br />
ISBN: <input type="text" name="isbn1"> <br />
Product name: <input type="text" name="proname"> <br />
Dimensions: <input type="text" name="dimensions"> <br />
Selling price: <input type="text" name="sprice"> <br />
Weight: <input type="text" name="weight"> <br />
Code: <input type="text" name="code"> <br />
<input type="submit" name="anpsubmit" value="Add" />

</form>
</div> <!-- add new products div -->

<?php
//code for adding new products
$erors = array();// set an empty array that will contains the errors
if(isset($_POST['anpsubmit'])){ //logging in users
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);

$isbn1 = $connection->real_escape_string($_POST['isbn1']);
$proname = $connection->real_escape_string($_POST['proname']);
$dimensions = $connection->real_escape_string($_POST['dimensions']);
$sprice = $connection->real_escape_string($_POST['sprice']);
$weight = $connection->real_escape_string($_POST['weight']);
$code = $connection->real_escape_string($_POST['code']);

settype($sprice, "double");
settype($code, "integer");

/*
if ( $sprice == 0 || gettype($sprice) != "double") {
$erors[] = "Enter Numbers only PLS!!";
}
*/

if ( gettype($code) != "integer")
$erors[] = "Enter Numbers only PLS!!";

$num_length = strlen((string)$code);
if($num_length != 5) {
$erors[] = "Code can only be 5 numbers long!!";
}

// if isbn already in products table
$existquery = "SELECT * FROM  `products` WHERE  `ISBN` = {$isbn1}";
$exist = $connection->query($existquery);
if ($exist->num_rows > 0){
$erors[] = "This ISBN is already added!!<br /> 
enter a new ISBN.";
}

// if code already in products table
$existquery1 = "SELECT * FROM  `products` WHERE  `code` = {$code}";
$exist1 = $connection->query($existquery1);
if ($exist1->num_rows > 0){
$erors[] = "This code is already added!!<br /> 
enter a new code.";
}

if ( $isbn1 == 0 || strlen($isbn1) != 13) {
$erors[] = "ISBN cannot be less or greater than 13!!";
}// 13 numbers in isbn entered


if (count($erors) < 1){ // if no errors
$iquery1 = "INSERT INTO `products` (`ISBN`, `product name`, `dimensions`, `selling price`, `weight`, `code`) VALUES ({$isbn1}, {$proname}, {$dimensions}, '{$sprice}', {$weight}, '{$code}');";

$iquery2 = "INSERT INTO `youtube`.`products` (`ISBN`, `product name`, `dimensions`, `selling price`, `weight`, `code`) VALUES ({$isbn1}, {$proname}, '22 x 22 x 22', {$sprice}, '315g', {$code});";

if (!$insert1 = $connection->query($iquery1)) $erors[] = $connection->sqlstate;

} // if no errors
else { //errors!!!
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toindex();
}

} //post for adding new products

// Code for generating graph vsubmit
/*
if(isset($_POST['vsubmit']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$year = $_POST['years'];

$marray = array();
//$salesdata = array();
$msales = array();

// Select all months for sales year & put in array
$monthsnh = $connection->query("SELECT DISTINCT `month` FROM `tsales` WHERE `year` = {$year}");
while ($month = $monthsnh->fetch_assoc()){
	$marray[] = $month['month'];
}

// start logic of gathering monthly sales
foreach($marray as $month){
$mshandle = $connection->query("SELECT SUM(`amount`) AS 'amount' FROM `tsales` WHERE `year` = '{$year}' AND `month` = '{$month}'");

while($ms = $mshandle->fetch_assoc()){

$msales[] = $ms['amount'];
}

} // foreach($marray as $month){

$salesdata = array_combine($marray, $msales);

// Code for generating graph
$phparray = array("Jan", "Feb");
[<?php echo json_encode($marray); ?>],[<?php echo json_encode($msales); ?>]

} //post is set
*/
?>

<div id="vtproducts">
<form id="vtpform" method='post'>
View top 3 Products <br />
Year: 
<select name="years1">
<?php
$yearsh1 = $connection->query("SELECT DISTINCT `year` FROM `psales`");
while ($year = $yearsh1->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
</select> <br />
<button type="button" id="vtpsubmit">View top Products</button>
</form>
<div id="chart1"> </div>
</div> <!-- view top products div -->

<div id="vcproducts">
<form id="vcpform" action="filegraph2.php" method='post' >
View chart for Product By ISBN<br />
ISBN: <input type="text" name="isbn2"> <br />
Year:
<select name="years2">
<?php
$yearsh2 = $connection->query("SELECT DISTINCT `year` FROM `psales`");
while ($year = $yearsh2->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
</select> <br />
<input type="submit" name="vcisubmit" value="View" />
</form>

<form id="vcpform2" method='post' action="filegraph2.php">
View chart for Product By Code<br />
Code: <input type="text" name="code2"> <br />
Year:
<select name="years3">
<?php
$yearsh3 = $connection->query("SELECT DISTINCT `year` FROM `psales`");
while ($year = $yearsh3->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
</select> <br />
<input type="submit" name="vccsubmit" value="View" />
</form>
</div> <!-- view chart products div -->


<div id="chart2"> </div>
<div id="chart3"></div>
</body>
</html>
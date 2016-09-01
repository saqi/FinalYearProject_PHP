<?php
session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");  
header("Content-type: image/png");
include_once("includes/phpMyGraph5.0.php");

// SESSION VARIABLES

 if (!loggedin()){
$rmessage = "You must be logged in to use this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}


if(isset($_POST['viewtop'])){ // view top products
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);

$time = time();
$cyear = strftime("%Y",$time);

$risbn = '';
$months = array('blank','Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec');

$querytop = "SELECT  `ISBN` , `year`, SUM(  `quantity_sold` ) AS  `Total Quantity` FROM  `product_sales` GROUP BY  `ISBN` 
ORDER BY  `Total Quantity` ASC LIMIT 1,3";
$querytoph = $connection->query($querytop);

while ($row = $querytoph->fetch_assoc()){
$risbn = $row["ISBN"];
}
$marray1 = array();
$msarray1 = array();
$msales1 = array();
// Select all months for sales year & put in array
$monthsnh = $connection->query("SELECT DISTINCT `month` FROM `product_sales` WHERE `year` = {$cyear} AND `ISBN` = {$risbn}");
while ($month = $monthsnh->fetch_assoc()){
	$marray1[] = $month['month'];
}

foreach($marray1 as $number){
$msarray1[] = $months[$number];
}

// start logic of gathering monthly sales
foreach($marray1 as $monthn){
$mshandle = $connection->query("SELECT `ISBN`,  SUM(`quantity_sold`) AS 'Total Quantity' FROM `product_sales` WHERE `ISBN` = {$risbn} AND `month` = '{$monthn}' AND  `year` = {$cyear} GROUP BY `ISBN`");

while($ms = $mshandle->fetch_assoc()){
$msales1[] = $ms['Total Quantity'];
}
} // foreach($marray as $month){

$salesdata1 = array_combine($msarray1, $msales1);

/* 
$msarray2 = array();
$querytop2 = "SELECT  `ISBN` , `year`, SUM(  `quantity sold` ) AS  `Total Quantity` FROM  `psales` GROUP BY  `ISBN` 
ORDER BY  `Total Quantity` DESC LIMIT 2,3";
$querytoph = $connection->query($querytop2);

$marray2 = array();
$msales2 = array();

while ($row = $querytoph->fetch_assoc()){
$risbn = $row['ISBN'];

// Select all months for sales year & put in array
$monthsnh = $connection->query("SELECT DISTINCT `month` FROM `psales` WHERE `year` = {$cyear} AND `ISBN` = {$risbn}");
while ($month = $monthsnh->fetch_assoc()){
	$marray2[] = $month['month'];
}

foreach($marray2 as $number){
$msarray2[] = $months[$number];
}

// start logic of gathering monthly sales
foreach($marray2 as $month){
$mshandle = $connection->query("SELECT SUM(`quantity sold`) AS 'Total Quantity' FROM `psales` WHERE `year` = '{$cyear}' AND `month` = '{$month}' AND `ISBN` = {$risbn}");

while($ms = $mshandle->fetch_assoc()){
$msales2[] = $ms['Total Quantity'];
}
} // foreach($marray as $month){
}

$salesdata2 = array_combine($msarray2, $msales2);

$querytop3 = "SELECT  `ISBN` , `year`, SUM(  `quantity sold` ) AS  `Total Quantity` FROM  `psales` GROUP BY  `ISBN` 
ORDER BY  `Total Quantity` DESC LIMIT 3,4";
$querytoph = $connection->query($querytop3);

$msarray3 = array();
$marray3 = array();
$msales3 = array();

while ($row = $querytoph->fetch_assoc()){
$risbn = $row['ISBN'];

// Select all months for sales year & put in array
$monthsnh = $connection->query("SELECT DISTINCT `month` FROM `psales` WHERE `year` = {$cyear} AND `ISBN` = {$risbn}");
while ($month = $monthsnh->fetch_assoc()){
	$marray3[] = $month['month'];
}

foreach($marray3 as $number){
$msarray3[] = $months[$number];
}

// start logic of gathering monthly sales
foreach($marray3 as $month){
$mshandle = $connection->query("SELECT SUM(`quantity sold`) AS 'Total Quantity' FROM `psales` WHERE `year` = '{$cyear}' AND `month` = '{$month}' AND `ISBN` = {$risbn}");

while($ms = $mshandle->fetch_assoc()){
$msales3[] = $ms['Total Quantity'];
}
} // foreach($marray as $month){
}

$salesdata3 = array_combine($msarray3, $msales3);
 */

$cfg['title'] = "Graph for year {$cyear}";
    $cfg['width'] = 800;
    $cfg['height'] = 600;
	
	$data1 = $salesdata1;
	//$data2 = $salesdata2;
	//$data3 = $salesdata3;

	$graph = new phpMyGraph();

    //Parse
   $graph->parseVerticalColumnGraph($data1, $cfg);
   
} // POST is set for view op products


if(isset($_POST['vcisubmit'])){ //view chart products
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);

$risbn = $connection->real_escape_string($_POST['isbn2']);

$year = $connection->real_escape_string($_POST['years2']);

$erors = array();

//check for ISBN errors
$regex = "/\d{13}/";
if (!preg_match($regex, $risbn)){
$erors [] = "ISBN can only be numbers & 13 long";
}
//if isbn exists in products table
$iequery = "SELECT * FROM `products` WHERE `ISBN` = {$risbn}";
$iequeryh = $connection->query($iequery);
if ($iequeryh->num_rows < 1){
$erors[] = "This ISBN does not exist, please add this product or enter a new ISBN";
}

$time = time();
$cyear = strftime("%Y",$time);

$months = array('blank','Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec');

//if no errors
if(count($erors) < 1){ // if no erors
$marray1 = array();
$msarray1 = array();
$msales1 = array();
// Select all months for sales year & put in array
$monthsnh = $connection->query("SELECT DISTINCT `month` FROM `product_sales` WHERE `ISBN` = '{$risbn}'");
while ($month = $monthsnh->fetch_assoc()){
	$marray1[] = $month['month'];
}

foreach($marray1 as $number){
$msarray1[] = $months[$number];
}

// start logic of gathering monthly sales
foreach($marray1 as $monthn){
$mshandle = $connection->query("SELECT `ISBN`,  SUM(`quantity_sold`) AS 'Total Quantity' FROM `product_sales` WHERE `ISBN` = '{$risbn}' AND `month` = '{$monthn}' GROUP BY `ISBN`");

while($ms = $mshandle->fetch_assoc()){
$msales1[] = $ms['Total Quantity'];
}
} // foreach($marray as $month){

$salesdata1 = array_combine($msarray1, $msales1);

$cfg['title'] = "Graph for year {$cyear}";
    $cfg['width'] = 800;
    $cfg['height'] = 600;
	
	//$data1 = $salesdata1;
	
	$graph = new phpMyGraph();

    //Parse
   $graph->parseVerticalColumnGraph($salesdata1, $cfg);
   
   } // there are errors
   else {
   $rmessage = implode('<br />', $erors);
	$_SESSION['rmessage'] = $rmessage;
	toidex();
   }

} // vcisubmit is set


if(isset($_POST['vccsubmit'])){ //view chart products
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);

$rcode = $connection->real_escape_string($_POST['code2']);

$year = $connection->real_escape_string($_POST['years3']);

$erors = array();
// check for code errors
$regex = "/[^\d{5}]/";
if (preg_match($regex, $rcode)){
$erors [] = "code can only be numbers & 5 long";
}
// if code exists or not
$iequery = "SELECT * FROM `products` WHERE `code` = '{$rcode}' LIMIT 0,30";
$iequeryh = $connection->query($iequery);
if ($iequeryh->num_rows < 1){
$erors[] = "This code does not exist, please add this product or enter a new code";
}

$time = time();
$cyear = strftime("%Y",$time);

$months = array('blank','Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec');

//if no errors
if(count($erors) < 1){ // if no erors
$marray1 = array();
$msarray1 = array();
$msales1 = array();
// Select all months for sales year & put in array
$monthsnh = $connection->query("SELECT DISTINCT `month` FROM `product_sales`, `products` WHERE `product_sales`.`ISBN` = `products`.`ISBN` 
AND `code` = '{$rcode}'");
while ($month = $monthsnh->fetch_assoc()){
	$marray1[] = $month['month'];
}

foreach($marray1 as $number){
$msarray1[] = $months[$number];
}

// start logic of gathering monthly sales
foreach($marray1 as $monthn){
$mshandle = $connection->query("SELECT `product_sales`.`ISBN`,  SUM(`quantity_sold`) AS 'Total Quantity' FROM `product_sales`, `products` WHERE 
`product_sales`.`ISBN` = `products`.`ISBN` 
AND `code` = '{$rcode}' 
AND `month` = '{$monthn}' GROUP BY `ISBN`");

while($ms = $mshandle->fetch_assoc()){
$msales1[] = $ms['Total Quantity'];
}
} // foreach($marray as $month){

$salesdata1 = array_combine($msarray1, $msales1);

$cfg['title'] = "Graph for year {$cyear}";
    $cfg['width'] = 800;
    $cfg['height'] = 600;
	
	//$data1 = $salesdata1;
	
	$graph = new phpMyGraph();

    //Parse
   $graph->parseVerticalColumnGraph($salesdata1, $cfg);
   }
   else { // there are errors
	$rmessage = implode('<br />', $erors);
	$_SESSION['rmessage'] = $rmessage;
	tofile();
   }

} // vccsubmit is set


?>
<?php
session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");  



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

$iquery2 = "INSERT INTO `youtube`.`products` (`ISBN`, `product name`, `dimensions`, `selling price`, `weight`, `code`) VALUES ({$isbn1}, '{$proname}', '{$dimensions}', {$sprice}, '{$weight}', {$code});";

if (!$insert1 = $connection->query($iquery2)) $erors[] = $connection->sqlstate;

} // if no errors
else { //errors!!!
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
tofile();
}

toindex();
} //post for adding new products
?>
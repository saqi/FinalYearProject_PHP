<?php
require_once("constants.php");

$connection = new mysqli(DB_SERVER,DB_USER,DB_PASS, DB_NAME);

if (mysqli_connect_errno()) {
	exit("Database connection failed: " . mysqli_connect_error());}
?>
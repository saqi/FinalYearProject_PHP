<?php
session_start();
require_once("includes/connection.php"); 
require_once("includes/functions.php");

$_SESSION['loggedin'] = false;
toindex();
?>
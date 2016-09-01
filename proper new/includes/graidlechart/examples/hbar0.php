<?php

include("../graidle.php");

$y1=array(50,30,25,45);
$vlx=array("Question 1","Question 2","Question 3","Question 4");
$lg=array("Example One","Example Two","Example Three ","Example Four");

$graph = new Graidle("Tutorial 16 - Horizontal Bar");
$graph -> setValue($y1,'hb');
$graph -> setSecondaryAxis(1,1);
$graph -> setBgCl("#0E394F");
$graph -> setFontCl("#FFFFFF");
$graph -> setHeight(450);
$graph -> setWidth(450);
$graph -> setXvalue($vlx);
$graph -> setLegend($lg);
$graph -> setMulticolor();
$graph -> setExtLegend(2);
$graph -> setXtitle("VOTES");
$graph -> setXvalue($vlx);
$graph -> create();
$graph -> carry();
?>
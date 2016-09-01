<?php
include("../graidle.php");
$y0=array(5,25,50,75);
$y1=array(5,10,15,20,25,30,35,40,45,50);
$legend=array("GEN","FEB","MAR","APR","MAG","GIU","LUG","AGO");

$graidle=new graidle("Tutorial 12");
$graidle -> setAA(4);
$graidle -> setValue($y0,'p',"Torta 1");
$graidle -> setValue($y1,'p',"Torta 2");
$graidle -> setHeight(400);
$graidle -> setWidth(400);
$graidle -> setExtLegend(1);
$graidle -> create();
$graidle -> carry();
?>

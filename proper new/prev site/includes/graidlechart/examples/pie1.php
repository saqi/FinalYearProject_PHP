<?php
include("../graidle.php");
$y0=array(25,16,25,25,25,25,25,16);
$legend=array("GEN","FEB","MAR","APR","MAG","GIU","LUG","AGO");

$graidle=new graidle("Tutorial 11");
$graidle -> setValue($y0,'p');
$graidle -> setLegend($legend);
$graidle -> setExtLegend(0);
$graidle -> create();
$graidle -> carry();
?>
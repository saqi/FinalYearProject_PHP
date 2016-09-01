<?php
include("../graidle.php");
$y0=array(14,8,4,3,2,3,4,5);
$legend=array("GEN","FEB","MAR","APR","MAG","GIU","LUG","AGO");

$graidle=new graidle("Tutorial 10");
$graidle -> setValue($y0,'p');
$graidle -> setLegend($legend);
$graidle -> setExtLegend(2);
$graidle -> create();
$graidle -> carry();
?>
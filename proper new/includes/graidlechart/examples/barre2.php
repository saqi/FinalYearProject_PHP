<?php
include("../graidle.php");
$y1=array(3,6,10,8,5,8,6,6,6,4,5,9,7,0,11,11,11,3);
$y2=array(8,6,8,9,11,10,9,0,5,13,0,6,6,0,0,5,4,5);

$graidle = new graidle("Tutorial 3",16); 
$graidle -> setValue($y1,'b');
$graidle -> setValue($y2,'b');
$graidle -> setSecondaryAxis(1,1);
$graidle -> setHeight(500);
$graidle -> setWidth(750);
$graidle -> create();
$graidle -> carry();
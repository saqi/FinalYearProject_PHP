<?php
include("../graidle.php");
$y0=array(25,16,25,25,25,25,25,16);
$y1=array(20,25,20,20,16,9,20,0);
$y2=array(8,13,16,13,20,20,0,25);

$graidle = new graidle("Tutorial 6");
$graidle -> setValue($y0,'l');
$graidle -> setValue($y1,'l');
$graidle -> setValue($y2,'l');
$graidle -> setSecondaryAxis(1,0);
$graidle -> create();
$graidle -> carry();
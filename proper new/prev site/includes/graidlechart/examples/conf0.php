<?php
include("../graidle.php");
$y0=array(25,16,25,25,25,25,25,16);
$y1=array(20,25,20,20,16,9,20,0);
$y2=array(8,13,16,13,20,20,0,25);

$graidle = new graidle("Tutorial 8",30);
$graidle -> setValue($y0,'b',"Istogramma1");
$graidle -> setValue($y1,'l',"Linea1");
$graidle -> setValue($y2,'b',"Istogramma2");
$graidle -> setSecondaryAxis(1,0);
$graidle -> create();
$graidle -> carry();
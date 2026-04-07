<?php

include 'ArrayWrapper.php';

$arrayWrapper = new ArrayWrapper(['first' => 1, 'second' => 2, 'str' => '123456']);

$arrayWrapper->test = 'this is a test'; //set

echo $arrayWrapper->test; //get
echo "</br>";
unset($arrayWrapper->second); //unset
echo "</br>";
echo isset($arrayWrapper->first); //isset
echo isset($arrayWrapper->second); //isset
echo "</br>";
echo $arrayWrapper; //toString
echo "</br>";
$arr = $arrayWrapper(); // invoke
echo "</br>";
var_dump($arr);
echo "</br>";
echo $arrayWrapper('str'); //invoke 2
echo "</br>";
$arr2 = clone $arrayWrapper;
echo "</br>";
var_dump($arr2);

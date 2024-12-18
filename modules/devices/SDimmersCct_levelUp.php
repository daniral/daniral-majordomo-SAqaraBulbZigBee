<?php
/*
Увеличить яркость.(array('value'=>1--100)). Без  параметров +10.
*/

$level = $this->getProperty('level');
$inc;

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 100) {
  $inc = $params[value];
} else {
  $inc = '10';
}

$level += $inc;
 
if ($level > 100) {
  $level = 100;
}

if ($level == $this->getProperty('level')) {
  return;
}

$this->callMethod('setLevel', array('value' => $level));

<?php
/*
Увеличить температуру.(array("value"=>0--100)). Без  параметров +10.
*/

$inc;
$cctLevel = $this->getProperty('cctLevel');

if (isset($params[value]) && $params[value] >= 0 && $params[value] <= 100) {
  $inc = $params[value];
} else {
  $inc = '10';
}

$cctLevel += $inc;

if ($cctLevel > 100) {
  $cctLevel = 100;
}

if ($cctLevel == $this->getProperty('cctLevel')) {
  return;
}

$this->callMethod('setCct', array('value' => $cctLevel));

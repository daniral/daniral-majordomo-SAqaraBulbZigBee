<?php
/*
Уменьшить температуру.(array("value"=>0--100)). Без  параметров -10.
*/

$inc;
$cctLevel = $this->getProperty('cctLevel');

if (isset($params[value]) && $params[value] >= 0 && $params[value] <= 100) {
  $inc = $params[value] * -1;
} else {
  $inc = -10;
}

$cctLevel += $inc;

if ($cctLevel < 0) {
  $cctLevel = 0;
}

if ($cctLevel == $this->getProperty('cctLevel')) {
  return;
}

$this->callMethod('setCct', array('value' => $cctLevel));
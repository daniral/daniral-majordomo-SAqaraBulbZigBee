<?php
/*
Увеличить температуру.(array("value"=>1-50))
Без  параметров +10.
Увеличивает максимум до colorWorkMax
*/

$inc;
$colorLevel = $this->getProperty('colorLevel');

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 50) {
  $inc = $params[value];
  if ($inc < 0) {
    $inc = $inc * -1;
  }
} else {
  $inc = '10';
}

$colorLevel += $inc;

if ($colorLevel > 100) {
  $colorLevel = 100;
}

if ($colorLevel == $this->getProperty('colorLevel')) {
  return;
}

$this->callMethod('setColorLevel', array('value' => $colorLevel));

<?php
/*
Уменьшить яркость на (array("value"=>1-50)). Без  параметров на 10.
уменьшает минимум до 1%.
*/

$inc;
$brightnessLevel = $this->getProperty('brightnessLevel');

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 50) {
  $inc = $params[value];
  if ($inc > 0) {
    $inc = $inc * -1;
  }
} else {
  $inc = '-10';
}

$brightnessLevel += $inc;

if ($brightnessLevel < 1) {
  $brightnessLevel = 1;
}

if ($brightnessLevel == $this->getProperty('brightnessLevel')) {
  return;
}

$this->callMethod('setBrightnessLevel', array('value' => $brightnessLevel));

<?php
/*
Увеличить яркость.(array('value'=>1-50))
Без  параметров +10.
Увеличит максимум до brightnessWorkMax.
*/

$brightnessLevel = $this->getProperty('brightnessLevel');
$inc;

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 50) {
  $inc = $params[value];
  if ($inc < 0) {
    $inc = $inc * -1;
  }
} else {
  $inc = '10';
}

$brightnessLevel += $inc;

if ($brightnessLevel > 100) {
  $brightnessLevel = 100;
}

if ($brightnessLevel == $this->getProperty('brightnessLevel')) {
  return;
}

$this->callMethod('setBrightnessLevel', array('value' => $brightnessLevel));

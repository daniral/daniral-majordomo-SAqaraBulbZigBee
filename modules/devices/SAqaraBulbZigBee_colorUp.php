<?php
/*
Увеличить температуру.(array("value"=>1-50))
Без  параметров +10.
Увеличивает максимум до colorMax
*/

$inc;
$color = $this->getProperty('color');

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 50) {
  $inc = $params[value];
  if ($inc < 0) {
    $inc = $inc * -1;
  }
} else {
  $inc = '10';
}

$color += $inc;

if ($color > 100) {
  $color = 100;
}

if ($color == $this->getProperty('color')) {
  return;
}

$this->callMethod('setColor', array('value' => $color));

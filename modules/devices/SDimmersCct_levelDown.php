<?php
/*
Уменьшить яркость на (array("value"=>1--100)). Без  параметров на 10.
*/

$inc;
$level = $this->getProperty('level');

if (isset($params['value']) && $params['value'] > 0 && $params['value'] <= 100) {
  $inc = $params['value'] * -1;
} else {
  $inc = -10;
}

$level += $inc;

if ($level < 0) {
  $level = 0;
}

if ($level == $this->getProperty('level')) {
  return;
}

$this->callMethod('setLevel', array('value' => $level));

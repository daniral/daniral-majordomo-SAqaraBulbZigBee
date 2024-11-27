<?php

/*
Изменить температуру.(array('value'=>'C'-cold,'N'-neutral,'W'-warmest))
*/

$colorSet;
$pset;

if (isset($params[value])) {
  $pset = $params[value];
  if ($pset == 'C' || $pset == 'c') {
    $colorSet = 0;
  } else if ($pset == 'N' || $pset == 'n') {
    $colorSet = 50;
  } else if ($pset == 'W' || $pset == 'w') {
    $colorSet = 100;
  } else {
    return;
  }
  if ($this->getProperty('colorLevel') == $colorSet) {
    return;
  }
  $this->callMethod('setColorLevel', array('value' => $colorSet));
}
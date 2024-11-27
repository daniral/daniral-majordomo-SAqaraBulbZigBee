<?php

/*
Установить температуру.(array("value"=>colorWorkMin <--> colorWorkMax))
Без  параметров то что в colorLevelSeved.
Если colorLevelSeved пуст то холодный colorWorkMin.
*/

$new_color;
$c_seved = $this->getProperty('colorLevelSeved');

$this->setProperty('flag', '1');

if (isset($params['value']) && $params['value'] >= 0 && $params['value'] <= 100) {
	$new_color = $params['value'];
} else if ($c_seved) {
	$new_color = $c_seved;
} else {
	$new_color = 0;
}

$this->setProperty('colorLevel', $new_color);

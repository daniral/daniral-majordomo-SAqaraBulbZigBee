<?php

/*
Установить температуру.(array("value"=>colorMin <--> colorMax))
Без  параметров то что в colorSeved.
Если colorSeved пуст то холодный colorMin.
*/

$new_color;
$c_seved = $this->getProperty('colorSeved');
$brightnessSeved = $this->getProperty('brightnessSeved');

$this->setProperty('flag', '1');

if (isset($params['value']) && $params['value'] >= 0 && $params['value'] <= 100) {
	$new_color = $params['value'];
} else if ($c_seved) {
	$new_color = $c_seved;
} else {
	$new_color = 0;
}

$this->setProperty('color', $new_color);

if (!$this->getProperty('brightness')) {
	$this->setProperty('brightness', $brightnessSeved ? $brightnessSeved : 100);
}

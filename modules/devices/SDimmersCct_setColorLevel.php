<?php

/*
Флаг 1 - автовыключение не запустится.
Установить температуру.(array("value"=>0 <--> 100 %))
Без  параметров то что в colorLevelSeved.
Если colorLevelSeved пуст то 0 (холодный).
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

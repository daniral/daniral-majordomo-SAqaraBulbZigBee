<?php

/*
Флаг 1 - автовыключение не запустится.
Установить температуру.(array("value"=>0 <--> 100 %))
Без  параметров то что в cctSeved.
Если cctSeved пуст то 0 (холодный).
*/

$newCct;
$cctSeved = $this->getProperty('cctSeved');

if (!str_contains($params['SOURCE'], 'dayNight')) {
	$this->setProperty('flag', '1');
}
if (isset($params['value']) && $params['value'] >= 0 && $params['value'] <= 100) {
	$newCct = $params['value'];
} else if ($cctSeved) {
	$newCct = $cctSeved;
} else {
	$newCct = 0;
}

if (!str_contains($params['SOURCE'], 'cctWorkUpdated')) {
	$this->setProperty('cctLevel', $newCct);
} else {
	$this->setProperty('cctLevel', $newCct, 'cctWorkUpdated');
}

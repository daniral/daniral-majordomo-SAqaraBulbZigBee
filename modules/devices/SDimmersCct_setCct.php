<?php

/*
Флаг 1 - автовыключение не запустится.
Установить температуру.(array("value"=>0 <--> 100 %))
Без  параметров то что в cctSeved.
Если cctSeved пуст то 0 (холодный).
Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.
*/

$cctSeved = $this->getProperty('cctSeved');
$newCct;

if (isset($params['value'])) {
    $newCct = strtolower($params['value']);
} elseif ($cctSeved) {
    $newCct = $cctSeved;
} else {
	$newCct = 0;
}

$this->setProperty('flag', 1);

$presets = array(
    'cool' => 0,
    'neutral' => 50,
    'warm' => 100,
);

if (isset($presets[$newCct])) {
    $newCct = $presets[$newCct];
}
if (is_numeric($newCct) && $newCct >= 0 && $newCct <= 100) {
    $this->setProperty('cctLevel', $newCct);
}



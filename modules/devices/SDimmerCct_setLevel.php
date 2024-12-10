<?php

/*
Флаг 1 - автовыключение не запустится.
Установить яркость света.(array("value"=> 0 <--> 100 %))
Без  параметров то что в levelSaved.
Если levelSaved пусто то 100%.
*/

$levelSaved = $this->getProperty('levelSaved');
$newLevel;

$this->setProperty('flag', '1');

if (isset($params['value']) && $params['value'] >= 0 && $params['value'] <= 100) {
	$newLevel = $params['value'];
	if ($newLevel == 0) {
		$this->setProperty('flag', 0);
		$this->setProperty('illuminanceFlag', 0);
	}
} else if ($levelSaved) {
	$newLevel = $levelSaved;
} else {
	$newLevel = 100;
}

$this->setProperty('level', $newLevel);

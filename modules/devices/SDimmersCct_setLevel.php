<?php

/*
Флаг 1 - автовыключение не запустится.
Установить яркость света.(array("value"=> 0 <--> 100 %))
Без  параметров то что в levelSaved.
Если levelSaved пусто то 100%.
*/

$levelSaved = $this->getProperty('levelSaved');
$newLevel;

if (isset($params['value'])) {
    $newLevel =$params['value'];
}elseif ($levelSaved) {
	$newLevel = $levelSaved;
} else {
	$newLevel = 100;
}

$this->setProperty('flag', 1);

if (is_numeric($newLevel) && $newLevel >= 0 && $newLevel <= 100) {
	if ($newLevel == 0) {
		$this->setProperty('flag', 0);
		$this->setProperty('illuminanceFlag', 0);
	}
	$this->setProperty('level', $newLevel);
} 



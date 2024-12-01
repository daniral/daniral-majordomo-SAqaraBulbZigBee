<?php

/*

Переводит рабочие еденицы теплоты (colorWorkMin <--> colorWorkMax) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в colorLevelSeved

*/

$colorLevelNew = $params['NEW_VALUE'];
$colorLevelOld = $params['OLD_VALUE'];
$colorWorkMin = $this->getProperty('colorWorkMin');
$colorWorkMax = $this->getProperty('colorWorkMax');
$brightnessLevelSeved=$this->getProperty('brightnessLevelSeved');

if ($colorLevelNew == $colorLevelOld || $colorLevelNew < 0 || $colorLevelNew > 100) return;

if ($colorWorkMin != $colorWorkMax) {
	$colorLevelWork = round($colorWorkMin + round(($colorWorkMax - $colorWorkMin) * $colorLevelNew / 100));
	//$diffcctLevel = abs($colorLevelOld - $colorLevelWork);
	//if ($diffcctLevel >= 2) {
		$this->setProperty('colorWork', $colorLevelWork);
		if ($this->getProperty('flag')) {
			$this->setProperty('colorLevelSeved', $colorLevelNew);
        }
        if (!$this->getProperty('brightnessLevel')) {
            $this->setProperty('brightnessLevel', $brightnessLevelSeved ? $brightnessLevelSeved : 100);
        }
	//}
}
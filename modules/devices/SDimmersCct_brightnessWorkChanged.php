<?php

/*

Запускается при изменении рабочнго уровня.
Переводит в проценты и пишет в brightnessLevel.

*/

$brightnessWorkNew = $params['NEW_VALUE'];
$brightnessWorkOld = $params['OLD_VALUE'];
$brightnessWorkMin = $this->getProperty('brightnessWorkMin');
$brightnessWorkMax = $this->getProperty('brightnessWorkMax');

if ($brightnessWorkNew == $brightnessWorkOld || ($brightnessWorkNew < $brightnessWorkMin && $brightnessWorkNew > $brightnessWorkMax)) return;

if ($brightnessWorkMin != $brightnessWorkMax) {
    $brightnessLevel = round(($brightnessWorkNew - $brightnessWorkMin) / (round($brightnessWorkMax - $brightnessWorkMin)) * 100);
    //$this->setProperty('brightnessLevel', $brightnessLevel);
}

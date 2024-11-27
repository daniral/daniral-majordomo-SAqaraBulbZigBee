<?php

$colorWorkNew = $params['NEW_VALUE'];
$colorWorkOld = $params['OLD_VALUE'];
$colorWorkMin = $this->getProperty('colorWorkMin');
$colorWorkMax = $this->getProperty('colorWorkMax');

if ($colorWorkNew == $colorWorkOld || ($colorWorkNew < $colorWorkMin && $colorWorkNew > $colorWorkMax)) return;

if ($colorWorkMin != $colorWorkMax) {
	$colorLevel = round(($colorWorkNew - $colorWorkMin) / (round($colorWorkMax - $colorWorkMin)) * 100);
	$this->setProperty('colorLevel', $colorLevel);
}

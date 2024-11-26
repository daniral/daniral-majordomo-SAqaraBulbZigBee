<?php

$colorWorkNew = $params['NEW_VALUE'];
$colorWorkOld = $params['OLD_VALUE'];
$colorMinWork = $this->getProperty('colorMin');
$colorMaxWork = $this->getProperty('colorMax');

if ($colorWorkNew == $colorWorkOld || ($colorWorkNew < $colorMinWork && $colorWorkNew > $colorMaxWork)) return;

if ($colorMinWork != $colorMaxWork) {
	$color = round(($colorWorkNew - $colorMinWork) / (round($colorMaxWork - $colorMinWork)) * 100);
	$this->setProperty('color', $color);
}

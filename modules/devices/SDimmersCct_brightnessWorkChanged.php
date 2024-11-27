<?php

$brightnessWorkNew = $params['NEW_VALUE'];
$brightnessWorkOld = $params['OLD_VALUE'];
$brightMinWork = $this->getProperty('brightnessMin');
$brightMaxWork = $this->getProperty('brightnessMax');

if ($brightnessWorkNew == $brightnessWorkOld || ($brightnessWorkNew < $brightMinWork && $brightnessWorkNew > $brightMaxWork)) return;

if ($brightMinWork != $brightMaxWork) {
    $brightness = round(($brightnessWorkNew - $brightMinWork) / (round($brightMaxWork - $brightMinWork)) * 100);
    $this->setProperty('brightness', $brightness);
}

<?php
$brightLevelNew = $params['NEW_VALUE'];
$brightLevelOld = $params['OLD_VALUE'];
$brightMinWork = $this->getProperty('brightnessMin');
$brightMaxWork = $this->getProperty('brightnessMax');

if ($brightLevelNew == $brightLevelOld || ($brightLevelNew < 0 && $brightLevelNew > 100)) return;

if ($brightMinWork != $brightMaxWork) {
    $brightLevelWork = round($brightMinWork + round(($brightMaxWork - $brightMinWork) * $brightLevelNew / 100));
    $diffbrightLevel = abs($brightLevelOld - $brightLevelWork);
    if ($diffbrightLevel >= 3) {
        $this->setProperty('brightnessWork', $brightLevelWork);
        if ($brightLevelNew > 0 && $this->getProperty('flag')) {
            $this->setProperty('brightnessSeved', $brightLevelNew);
        }
    }
}









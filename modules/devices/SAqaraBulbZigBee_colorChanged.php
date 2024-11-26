<?php
$colorLevelNew = $params['NEW_VALUE'];
$colorLevelOld = $params['OLD_VALUE'];
$colorMinWork = $this->getProperty('colorMin');
$colorMaxWork = $this->getProperty('colorMax');

if ($colorLevelNew == $colorLevelOld || ($colorLevelNew < 0 && $colorLevelNew > 100)) return;

if ($colorMinWork != $colorMaxWork) {
	$colorLevelWork = round($colorMinWork + round(($colorMaxWork - $colorMinWork) * $colorLevelNew / 100));
	$diffcctLevel = abs($colorLevelOld - $colorLevelWork);
	if ($diffcctLevel >= 3) {
		$this->setProperty('colorWork', $colorLevelWork);
        $this->setProperty('colorSeved', $colorLevelNew);
        if (!$this->getProperty('brightness')) {
            $this->setProperty('brightness', $brightnessSeved ? $brightnessSeved : 100);
        }
	}
}
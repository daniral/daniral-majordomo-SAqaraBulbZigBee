<?php

/*

Переводит рабочие еденицы теплоты (cctMinWork <--> cctMaxWork) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в cctSeved

*/

$cctNew = $params['NEW_VALUE'];
$cctOld = $params['OLD_VALUE'];
$cctMinWork = $this->getProperty('cctMinWork');
$cctMaxWork = $this->getProperty('cctMaxWork');
$levelSaved = $this->getProperty('levelSaved');

//if ($cctNew == $cctOld || $cctNew < 0 || $cctNew > 100) return;
if ($cctNew < 0 || $cctNew > 100) return;

if ($cctMinWork != $cctMaxWork) {
	$cctLevelWork = round($cctMinWork + round(($cctMaxWork - $cctMinWork) * $cctNew / 100));
	$this->setProperty('cctWork', $cctLevelWork);
	if ($this->getProperty('flag')) {
		$this->setProperty('cctSeved', $cctNew);
	}
	if (!$this->getProperty('level')) {
		$this->setProperty('level', $levelSaved ? $levelSaved : 100);
	}
}

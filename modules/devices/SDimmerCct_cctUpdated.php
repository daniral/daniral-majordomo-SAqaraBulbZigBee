<?php

/*

Переводит рабочие еденицы теплоты (cctMinWork <--> cctMaxWork) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в cctSeved

*/

$cctNew = $params['NEW_VALUE'];
$cctLevel = $this->getProperty('cctLevel');
$cctMinWork = $this->getProperty('cctMinWork');
$cctMaxWork = $this->getProperty('cctMaxWork');
$levelSaved = $this->getProperty('levelSaved');

if ($cctNew < 0 || $cctNew > 100 || $cctNew == $cctLevel) return;

if ($cctMinWork != $cctMaxWork) {
	$cctLevelWork = round($cctMinWork + round(($cctMaxWork - $cctMinWork) * $cctNew / 100));
	if (!str_contains($params['SOURCE'], 'cctWorkUpdated')) {
		$this->setProperty('cctWork', $cctLevelWork);
    }

	if ($this->getProperty('flag')) {
		$this->setProperty('cctSeved', $cctNew);
	}
	if (!$this->getProperty('level')) {
		$this->setProperty('level', $levelSaved ? $levelSaved : 100);
	}
}

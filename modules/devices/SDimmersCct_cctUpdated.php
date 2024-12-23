<?php
/*
Переводит из процентов (0 <--> 100) в рабочие еденицы теплоты в пределах (cctMinWork <--> cctMaxWork)
Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.
Сохраняет предыдущее значение уровня в cctSeved
*/

$cctNew = strtolower($params['NEW_VALUE']);
$cctOld = $this->getProperty('cctLevel');
$cctMinWork = $this->getProperty('cctMinWork');
$cctMaxWork = $this->getProperty('cctMaxWork');
$levelSaved = $this->getProperty('levelSaved');

$presets = array(
    'cool' => 0,
    'neutral' => 50,
    'warm' => 100,
);

if (isset($presets[$cctNew])) {
    $cctNew = $presets[$cctNew];
}

if ($cctNew == $cctOld || $cctNew < 0 || $cctNew > 100) return;

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

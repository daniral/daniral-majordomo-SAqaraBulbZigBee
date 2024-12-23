<?php
/*
Переводит из процентов (0 <--> 100) в рабочие еденицы теплоты в пределах (cctMinWork <--> cctMaxWork)
Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.
Сохраняет предыдущее значение уровня в cctSeved
*/

$cctNew = strtolower($params['NEW_VALUE']);
$cctOld = strtolower($params['OLD_VALUE']);
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
	$this->setProperty('cctLevel', $cctNew);
}elseif (!is_numeric($cctNew)) {
	$cctNew=$cctOld;
	$this->setProperty('cctLevel', $cctNew);
}

if($cctNew < 0) {
	$cctNew = 0;
	$this->setProperty('cctLevel', $cctNew);
}elseif($cctNew > 100) {
	$cctNew = 100;
	$this->setProperty('cctLevel', $cctNew);
}

if ($cctMinWork != $cctMaxWork && $cctNew != $cctOld) {
	$cctLevelWork = round($cctMinWork + round(($cctMaxWork - $cctMinWork) * $cctNew / 100));
	$this->setProperty('cctWork', $cctLevelWork);
	if ($this->getProperty('flag')) {
		$this->setProperty('cctSeved', $cctNew); 
	}
	if (!$this->getProperty('level')) {
		$this->setProperty('level', $levelSaved ? $levelSaved : 100);
	}
}

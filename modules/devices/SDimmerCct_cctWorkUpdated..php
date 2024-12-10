<?php

/*

Запускается при изменении рабочнго уровня.
Переводит в проценты и пишет в cctLevel.

*/
/*
$cctWorkNew = $params['NEW_VALUE'];
$cctWorkOld = $params['OLD_VALUE'];
$cctMinWork = $this->getProperty('cctMinWork');
$cctMaxWork = $this->getProperty('cctMaxWork');

if ($cctWorkNew == $cctWorkOld || ($cctWorkNew < $cctMinWork && $cctWorkNew > $cctMaxWork)) return;

if ($cctMinWork != $cctMaxWork) {
	$cctLevel = round(($cctWorkNew - $cctMinWork) / (round($cctMaxWork - $cctMinWork)) * 100);
	//$this->setProperty('cctLevel', $cctLevel);
}
*/
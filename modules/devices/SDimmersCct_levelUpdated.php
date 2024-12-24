<?php
/*
Переводит из процентов (0 <--> 100) в рабочие еденицы яркости в предеелах (minWork <--> maxWork) 
Сохраняет предыдущее значение уровня в levelSaved
*/

$levelNew = $params['NEW_VALUE'];
$levelOld = $params['OLD_VALUE'];
$minWork = $this->getProperty('minWork');
$maxWork = $this->getProperty('maxWork');

if ($levelNew == $levelOld || $levelNew < 0 || $levelNew > 100) return;

if ($minWork != $maxWork) {
    $levelWork = round($minWork + round(($maxWork - $minWork) * $levelNew / 100));
    if ($levelWork == 0) {
        $this->callMethod('turnOff');
        //$this->setProperty('flag', 0);
        //$this->setProperty('illuminanceFlag', 0);
    }
    $this->setProperty('levelWork', $levelWork);

    if ($levelNew > 0 && $this->getProperty('flag')) {
        $this->setProperty('levelSaved', $levelNew);
    }
}


<?php

/*

Переводит рабочие еденицы яркости (minWork <--> maxWork) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в levelSaved

*/

$levelNew = $params['NEW_VALUE'];
$levelOld = $params['OLD_VALUE'];
$minWork = $this->getProperty('minWork');
$maxWork = $this->getProperty('maxWork');


//if ($levelNew == $levelOld || $levelNew < 0 || $levelNew > 100) return;
if ($levelNew < 0 || $levelNew > 100) return;

if ($minWork != $maxWork) {
    $brightLevelWork = round($minWork + round(($maxWork - $minWork) * $levelNew / 100));
    $this->setProperty('levelWork', $brightLevelWork);
    if ($levelNew > 0 && $this->getProperty('flag')) {
        $this->setProperty('levelSaved', $levelNew);
    }
}

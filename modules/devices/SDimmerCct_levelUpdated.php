<?php

/*

Переводит рабочие еденицы яркости (minWork <--> maxWork) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в levelSaved

*/

$levelNew = $params['NEW_VALUE'];
$level = $this->getProperty('level');
$minWork = $this->getProperty('minWork');
$maxWork = $this->getProperty('maxWork');

if ($levelNew < 0 || $levelNew > 100 || $levelNew == $level) return;

if ($minWork != $maxWork) {
    $brightLevelWork = round($minWork + round(($maxWork - $minWork) * $levelNew / 100));
    if (!str_contains($params['SOURCE'], 'levelWorkUpdated')) {
        $this->setProperty('levelWork', $brightLevelWork);
    }
    if ($levelNew > 0 && $this->getProperty('flag')) {
        $this->setProperty('levelSaved', $levelNew);
    }
}

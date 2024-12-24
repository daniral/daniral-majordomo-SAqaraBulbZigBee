<?php

/*
Флаг 1 - авто режим и автовыключение не запустится.
Установить яркость света.(array("value"=> 0 <--> 100 %))
*/

if (!isset($params['value']) || !is_numeric($params['value']) || $params['value'] < 0 || $params['value'] > 100) return;
if ($params['value'] > 0) {
    $this->setProperty('flag', 1);
} else {
    $this->setProperty('flag', 0);
    $this->setProperty('illuminanceFlag', 0);
}

$this->setProperty('level', $params['value']);

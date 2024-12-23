<?php

/*
Флаг 1 - авто режим и автовыключение не запустится.
Установить яркость света.(array("value"=> 0 <--> 100 %))
*/

if (!$params['value'] || !is_numeric($params['value']) || $params['value'] < 0 || $params['value'] > 100) return;
$this->setProperty('flag', 1);
$this->setProperty('level', $params['value']);

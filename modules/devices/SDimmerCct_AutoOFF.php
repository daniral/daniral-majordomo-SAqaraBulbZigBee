<?php

/*
Автовыключение через свойство:timerOFF секунд если 0 не выключает.
Запускается из метода turnOn если он был запущен в режиме ночной подсветки dayNight=>1.
*/

$name = $this->object_title;

if ($this->getProperty('timerOFF') != 0) {
  $timerCode=<<<EOT
    if (!getGlobal('$name.flag') && !getGlobal('$name.presence')) {
	  callMethod('$name.turnOff');
    }
EOT;
  setTimeOut($name."Timer", $timerCode, (int)($this->getProperty('timerOFF')));
}
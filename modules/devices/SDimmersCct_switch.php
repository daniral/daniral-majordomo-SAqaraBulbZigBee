<?php
/*
Переключить состояние Вкл/Выкл.
если было включено в режиме подсветки то включить то что в brightnessLevelSeved и colorLevelSeved.
Еще запуск выключит.
Если было выключено включет то что в brightnessLevelSeved и colorLevelSeved.
*/

if (!$this->getProperty('brightnessLevel') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('brightnessLevel') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('brightnessLevel') && $this->getProperty('flag')) {
  $this->callMethod('turnOff');
}
<?php

/*
Запускается при изменении свойства presence
если 0 запустить AutoOff
*/

if (!$this->getProperty('presence')) {
  $this->callMethod('AutoOff');
}
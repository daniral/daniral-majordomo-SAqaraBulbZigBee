<?php
/*
Надо привязать к свойствам:
    brightnessWork - brightness лампочки.
      Добавить Путь (write): zigbee2mqtt/Название устройства/set/brightness
    colorWork - color_temp лампочки.
      Добавить Путь (write): zigbee2mqtt/Название устройства/set/color_temp
    status - state лампочки.
      В статус не добовляем путь(write) так как он нужен только для обратной связи
      что бы знать включена или нет лапочка для сцен или кнопок.
  Минимальные и максимальные рабочие уровни:
    Например для лампочек Xiaomi ZigBee это:
      - brightnessWorkMax - 254
      - brightnessWorkMin - 0
      - colorWorkMax - 370
      - colorWorkMin - 153
    а для лампочек Tuta ZigBee это:
      - brightnessWorkMax - 254
      - brightnessWorkMin - 0
      - colorWorkMax - 500
      - colorWorkMin - 153


                                  ОБЫЧНЫЙ РЕЖИМ:

Включить - callMethod('имя объекта '.'turnOn'); 
  Если без параметров установит то что в brightnessLevelSeved и colorLevelSeved.
  Если brightnessLevelSeved и colorLevelSeved пусто то на полную яркость(100%) и холодный цвет(0%).
  С параметрами:
    - callMethod('имя объекта.turnOn', array('brightnessLevel'=> 1<-->100,'colorLevel'=> 0<-->100));
    - callMethod('имя объекта.turnOn', array('brightnessLevel'=> 1<-->100));
    - callMethod('имя объекта.turnOn', array('colorLevel'=> 0<-->100));

Устанавливается flag=1. Стопер который не дает запускаться методу AutoOFF.


                                 РЕЖИМ ПОДСВЕТКИ:      

Включить ночной режим - callMethod('имя объекта '.'turnOn', array('dayNight'=>1));
Включится на время которое указано в timerOFF(сек). Если 0 то включится но сам не выключится.
Если в presence(например данные с датчика присутствия) 1 то не выключится.
  Как только в presence изменися с 1 на 0 запустится метод автовыключения.
Можно включать режим подсветки Днем,Ночью или весь день.
  если в workInDai:
    0-Весь день.(Ночью ночные установки яркости и теплоты. Днем дневные.)
    1-Днем
    2-Ночью
Если по солнцу:
  после захода - ночные установки яркости (nightBrightnessLevel) и теплоты (nightColorLevel).
  после восхода - дневные (dayBrightnessLevel, dayColorLevel).
  Надо обязательно писать в свойства sunriseTime и sunsetTime время восхода и заката.
  Если не указано то то что указано в ручную.
  К восходу и закату можно прибавить или отнять время если надо чтобы включалось или выключалось раньше или позже:
   - addTimeSunrise - к рассвету в формате 05:30 (5 часов 30 минут)
     - signSunrise 0 - отнять 1 - прибавить.
   - addTimeSunset  - к закату в формате 00:30 (30 минут)
     - signSunset 0 - отнять 1 - прибавить.
Если вручную:
  после начало ночь - ночные установки яркости и теплоты.
  после начло день - дневные.
Если по датчику:
  Только ночные установки яркости и теплоты.
  Если надо можно дописать разные установки для дня и ночи.
  Всвойство illuminance надо писать данные с датчика освещения.
  если illuminance меньше чем установленно в illuminanceMax подсветка вкится.
  Работу по датчику освещения не проверял так как не имеется в наличии.
Можно запустить режим подсветки с параметпами:
  - callMethod('имя объекта.turnOn', array('dayNight'=>1, 'brightnessLevel'=> 1<--> 100,'colorLevel'=> 0<-->100));

Устанавливается flag=0. Запускается метод AutoOFF.

Методы:
  - setBrightnessLevel -  Установить яркость света.(array("value"=> 0 <--> 100 %))
                          Без  параметров то что в brightnessLevelSeved.
                          Если brightnessLevelSeved пусто то 100%.
                          flag 1 - автовыключение не запустится.
  - setColorLevel - Установить температуру.(array("value"=>0 <--> 100 %))
                    Без  параметров то что в colorLevelSeved.
                    Если colorLevelSeved пуст то 0 (холодный).
                    flag 1 - автовыключение не запустится.
  - brightnessLevelDown - Уменьшить яркость.(array("value"=>1-50)). Без  параметров -10.
  - brightnessLevelUp - Увеличить яркость.(array("value"=>1-50)). Без  параметров 10.
  - colorLevelDown - Уменьшить температуру.(array("value"=>1-50)). Без  параметров -10.
  - colorleveUp - Увеличить температуру.(array("value"=>1-50)). Без  параметров 10.
  - byDefault - Установит параметры по дефолту. Это если что-то пошло не так. 
      При первом запуске метода turnOn тоже все выставится по дефолту.
  - CommandsMenu - Создаст меню данного объекта в "Меню Управления"
  - colorPreset - Установить температуру ('C'-Холодная,'N'-Нейтральная,'W'-Теплая).
      - array('value'=>'C');


При первом запуске все нужные свойства для работы метода должны прописаться сами.
Если нужны другие то можно изменить в ручную в свойствах объекта или запустить мктод CommandsMenu.
Он сам создаст меню в "Меню Управления" и там можно все удобно настроить.
Меню будет называться по имени объекта. При желании можно изменить на любое другое.

Было проверено на лампочках Xiaomi ZigBee https://www.zigbee2mqtt.io/devices/ZNLDP12LM.html#aqara-znldp12lm
И на потолочной лампе от Tuta ZigBee https://www.zigbee2mqtt.io/devices/ZB-LZD10-RCW.html#moes-zb-lzd10-rcw

*/

if ($this->getProperty('dayBrightnessLevel') == '') $this->setProperty('dayBrightnessLevel', '100');
if ($this->getProperty('dayColorLevel') == '') $this->setProperty('dayColorLevel', '0');
if ($this->getProperty('nightBrightnessLevel') == '') $this->setProperty('nightBrightnessLevel', '10');
if ($this->getProperty('nightColorLevel') == '') $this->setProperty('nightColorLevel', '100');
if ($this->getProperty('brightnessWorkMin') == '') $this->setProperty('brightnessWorkMin', '0');
if ($this->getProperty('brightnessWorkMax') == '') $this->setProperty('brightnessWorkMax', '254');
if ($this->getProperty('colorWorkMin') == '') $this->setProperty('colorWorkMin', '153');
if ($this->getProperty('colorWorkMax') == '') $this->setProperty('colorWorkMax', '370');
if ($this->getProperty('timerOFF') == '') $this->setProperty('timerOFF', '120');
if ($this->getProperty('presence') == '') $this->setProperty('presence', '0');
if ($this->getProperty('dayBegin') == '') $this->setProperty('dayBegin', '08:00');
if ($this->getProperty('nightBegin') == '') $this->setProperty('nightBegin', '18:00');
if ($this->getProperty('autoOnOff') == '') $this->setProperty('autoOnOff', '1');
if ($this->getProperty('flag') == '') $this->setProperty('flag', '0');
if ($this->getProperty('illuminanceFlag') == '') $this->setProperty('illuminanceFlag', '0');
if ($this->getProperty('illuminance') == '') $this->setProperty('illuminance', '0');
if ($this->getProperty('illuminanceMax') == '') $this->setProperty('illuminanceMax', '0');
if ($this->getProperty('bySensor') == '') $this->setProperty('bySensor', '0');
if ($this->getProperty('byManually') == '') $this->setProperty('byManually', '1');
if ($this->getProperty('bySunTime') == '') $this->setProperty('bySunTime', '0');
if ($this->getProperty('workInDai') == '') $this->setProperty('workInDai', '2');
if ($this->getProperty('addTimeSunrise') == '') $this->setProperty('addTimeSunrise', '00:00');
if ($this->getProperty('addTimeSunset') == '') $this->setProperty('addTimeSunset', '00:00');
if ($this->getProperty('signSunrise') == '') $this->setProperty('signSunrise', '1');
if ($this->getProperty('signSunset') == '') $this->setProperty('signSunset', '1');
if ($this->getProperty('sunriseTime') == '') $this->setProperty('sunriseTime', $this->getProperty('dayBegin'));
if ($this->getProperty('sunsetTime') == '') $this->setProperty('sunsetTime', $this->getProperty('nightBegin'));



$colorLevel = isset($params['colorLevel']) && $params['colorLevel'] >= 0 && $params['colorLevel'] <= 100 ? $params['colorLevel'] : 0;
$brightnessLevel = isset($params['brightnessLevel']) && $params['brightnessLevel'] > 0 && $params['brightnessLevel'] <= 100 ? $params['brightnessLevel'] : 0;
$dayNight = isset($params['dayNight']) && $params['dayNight'] == 1 ? 1 : 0;

$day_b;
$night_b;

if (!$dayNight) {
  if ($colorLevel) {
    $this->callMethod('setColorLevel', $colorLevel);
  } else {
    $this->callMethod('setColorLevel');
  }
  if ($brightnessLevel) {
    $this->callMethod('setBrightnessLevel', $brightnessLevel);
  } else {
    $this->callMethod('setBrightnessLevel');
  }
  return;
}

if ($dayNight && !$this->getProperty('flag')) {

  if ($this->getProperty('bySunTime') && $this->getProperty('sunriseTime') != '' && $this->getProperty('sunsetTime') != '') {
    $day_b = edit_time($this->getProperty('sunriseTime'), $this->getProperty('addTimeSunrise'), $this->getProperty('signSunrise'));
    $night_b = edit_time($this->getProperty('sunsetTime'), $this->getProperty('addTimeSunset'), $this->getProperty('signSunset'));
  } else if (!$this->getProperty('bySensor')) {
    $day_b = $this->getProperty('dayBegin');
    $night_b = $this->getProperty('nightBegin');
  }
  if ($this->getProperty('autoOnOff')) {
    if (($this->getProperty('workInDai') == '2' || $this->getProperty('workInDai') == '0') && !$this->getProperty('bySensor') && timeBetween($night_b, $day_b)) {
      $this->setProperty('brightnessLevel', $brightnessLevel ? $brightnessLevel : $this->getProperty('nightBrightnessLevel'));
      $this->setProperty('colorLevel', $colorLevel ? $colorLevel : $this->getProperty('nightColorLevel'));
      $this->callMethod('AutoOFF');
    }
    if (($this->getProperty('workInDai') == '1' || $this->getProperty('workInDai') == '0') && !$this->getProperty('bySensor') && timeBetween($day_b, $night_b)) {
      $this->setProperty('brightnessLevel', $brightnessLevel ? $brightnessLevel : $this->getProperty('dayBrightnessLevel'));
      $this->setProperty('colorLevel', $colorLevel ? $colorLevel : $this->getProperty('dayColorLevel'));
      $this->callMethod('AutoOFF');
    }
    if (($this->getProperty('bySensor') && $this->getProperty('illuminance') <= $this->getProperty('illuminanceMax')) || $this->getProperty('illuminanceFlag')) {
      $this->setProperty('brightnessLevel', $this->getProperty('nightBrightnessLevel'));
      $this->setProperty('colorLevel', $this->getProperty('nightColorLevel'));
      $this->setProperty('illuminanceFlag', 1);
      $this->callMethod('AutoOFF');
    }
  }
}

function edit_time($time, $addTime, $sign)
{
  $part = explode(':', $addTime);
  $addTime_sec = $part[0] * 3600 + $part[1] * 60 + $part[2];
  if (!$sign) {
    $addTime_sec = $addTime_sec * -1;
  }
  $res = strtotime($time) + $addTime_sec;
  return date('H:i', $res);
}

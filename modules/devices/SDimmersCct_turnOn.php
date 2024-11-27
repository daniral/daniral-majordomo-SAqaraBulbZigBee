<?php
/*

Включить ночной режим - callMethod('имя объекта '.'turnOn', array('dayNight'=>1)); если без параметров установит то что в nightBrightnessLevel и nightColorLevel. ( flag=0. AutoOFF запустится.)
Включить ночной режим с параметрами - callMethod('имя объекта.turnOn', array('brightnessLevel'=> 1 <--> brightnessWorkMax,'colorLevel'=>colorWorkMin <--> colorWorkMax,'dayNight'=>1)); (flag=0. AutoOFF запустится.)
Включить - callMethod('имя объекта '.'turnOn'); если без параметров установит то что в brightnessLevelSeved и colorLevelSeved.
Если brightnessLevelSeved и colorLevelSeved пусто то на полную яркость brightnessWorkMax и холодный цвет colorWorkMin.( flag=1. AutoOFF не запустится.)
Включить  с параметрами - callMethod('имя объекта.turnOn', array('brightnessLevel'=>brightnessWorkMin <--> brightnessWorkMax,'colorLevel'=>colorWorkMin <--> colorWorkMax));  (flag=1. AutoOFF не запустится.)

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

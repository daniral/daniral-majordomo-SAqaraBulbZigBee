<?php
/*

Включить ночной режим - callMethod('имя объекта '.'turnOn', array('dayNight'=>1)); если без параметров установит то что в nightBrightness и nightColor. ( flag=0. AutoOFF запустится.)
Включить ночной режим с параметрами - callMethod('имя объекта.turnOn', array('brightness'=> 1 <--> brightnessMax,'color'=>colorMin <--> colorMax,'dayNight'=>1)); (flag=0. AutoOFF запустится.)
Включить - callMethod('имя объекта '.'turnOn'); если без параметров установит то что в brightnessSeved и colorSeved.
Если brightnessSeved и colorSeved пусто то на полную яркость brightnessMax и холодный цвет colorMin.( flag=1. AutoOFF не запустится.)
Включить  с параметрами - callMethod('имя объекта.turnOn', array('brightness'=>brightnessMin <--> brightnessMax,'color'=>colorMin <--> colorMax));  (flag=1. AutoOFF не запустится.)

*/

if ($this->getProperty('dayBrightness') == '') $this->setProperty('dayBrightness', '100');
if ($this->getProperty('dayColor') == '') $this->setProperty('dayColor', '0');
if ($this->getProperty('nightBrightness') == '') $this->setProperty('nightBrightness', '10');
if ($this->getProperty('nightColor') == '') $this->setProperty('nightColor', '100');
if ($this->getProperty('brightnessMin') == '') $this->setProperty('brightnessMin', '0');
if ($this->getProperty('brightnessMax') == '') $this->setProperty('brightnessMax', '254');
if ($this->getProperty('colorMin') == '') $this->setProperty('colorMin', '153');
if ($this->getProperty('colorMax') == '') $this->setProperty('colorMax', '370');
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

$color = isset($params['color']) && $params['color'] >= 0 && $params['color'] <= 100 ? $params['color'] : 0;
$brightness = isset($params['brightness']) && $params['brightness'] > 0 && $params['brightness'] <= 100 ? $params['brightness'] : 0;
$dayNight = isset($params['dayNight']) && $params['dayNight'] == 1 ? 1 : 0;

$day_b;
$night_b;

if (!$dayNight) {
  if ($color) {
    $this->callMethod('setColor', $color);
  } else {
    $this->callMethod('setColor');
  }
  if ($brightnes) {
    $this->callMethod('setBrightness', $brightnes);
  } else {
    $this->callMethod('setBrightness');
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
      $this->setProperty('brightness', $brightnes ? $brightnes : $this->getProperty('nightBrightness'));
      $this->setProperty('color', $color ? $color : $this->getProperty('nightColor'));
      $this->callMethod('AutoOFF');
    }
    if (($this->getProperty('workInDai') == '1' || $this->getProperty('workInDai') == '0') && !$this->getProperty('bySensor') && timeBetween($day_b, $night_b)) {
      $this->setProperty('brightness', $brightnes ? $brightnes : $this->getProperty('dayBrightness'));
      $this->setProperty('color', $color ? $color : $this->getProperty('dayColor'));
      $this->callMethod('AutoOFF');
    }
    if (($this->getProperty('bySensor') && $this->getProperty('illuminance') <= $this->getProperty('illuminanceMax')) || $this->getProperty('illuminanceFlag')) {
      $this->setProperty('brightness', $this->getProperty('nightBrightness'));
      $this->setProperty('color', $this->getProperty('nightColor'));
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

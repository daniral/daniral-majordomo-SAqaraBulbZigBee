<?php

if (!$this->getProperty('brightnessLevel') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('brightnessLevel') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('brightnessLevel') && $this->getProperty('flag')) {
  $this->callMethod('turnOff');
}
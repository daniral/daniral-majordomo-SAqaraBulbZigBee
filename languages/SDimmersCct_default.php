<?php

$dictionary = array(

 'SDimmersCct_PATTERN_BRIGHTNESS' => 'brightness',
 'SDimmersCct_PATTERN_COLORTEMPERATURE' => 'temperature'

);

foreach ($dictionary as $k => $v) {
 if (!defined('LANG_' . $k)) {
  @define('LANG_' . $k, $v);
 }
}

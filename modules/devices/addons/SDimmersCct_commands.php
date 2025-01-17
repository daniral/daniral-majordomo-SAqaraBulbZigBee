<?php

if ($device_type == 'SDimmersCct') {
 if (preg_match('/' . LANG_DEVICES_PATTERN_TURNON . '/uis', $command)) {
  sayReplySafe(LANG_TURNING_ON . ' ' . $device_title . $add_phrase, 2);
  $run_code .= "callMethod('$linked_object.turnOn');";
  $opposite_code .= "callMethod('$linked_object.turnOff');";
  $processed = 1;
  //$reply_confirm = 1;
 }
 elseif (preg_match('/' . LANG_DEVICES_PATTERN_TURNOFF . '/uis', $command)) {
  sayReplySafe(LANG_TURNING_OFF . ' ' . $device_title . $add_phrase, 2);
  $run_code .= "callMethod('$linked_object.turnOff');";
  $opposite_code .= "callMethod('$linked_object.turnOn');";
  $processed = 1;
  //$reply_confirm = 1;
 }
  elseif (preg_match('/' . LANG_DEVICES_PATTERN_SWITCH . '/uis', $command)) {
  sayReplySafe(LANG_SWITCH . ' ' . $device_title . $add_phrase, 2);
  $run_code .= "callMethod('$linked_object.switch');";
  $opposite_code .= "callMethod('$linked_object.switch');";
  $processed = 1;
  //$reply_confirm = 1;
 }
 elseif (preg_match('/' . LANG_SDimmersCct_PATTERN_BRIGHTNESS . '/uis', $command)) {
  if(preg_match('/(?:\s)(\d{1,2}|100)(?:%|\s|$)/uis', $command, $matches)) {
   $opposite_code .= "callMethod('$linked_object.setLevel', array('value' => $matches[1]);";
   //$run_code .= "setGlobal('$linked_object.level', $matches[1]);";
   $processed = 1;
   $reply_confirm = 1;
  }
 }
 elseif (preg_match('/' . LANG_SDimmersCct_PATTERN_TEMPERATURE . '/uis', $command)) {
  if(preg_match('/(?:\s)(\d{1,2}|100)(?:%|\s|$)/uis', $command, $matches)) {
   $opposite_code .= "callMethod('$linked_object.setCct', array('value' => $matches[1]);";
   //$run_code .= "setGlobal('$linked_object.cctLevel', $matches[1]);";
   $processed = 1;
   $reply_confirm = 1;
  }
 }
}

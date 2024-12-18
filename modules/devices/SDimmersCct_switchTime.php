<?php

/*
Переключение между по солнцу/вручную/по сенсору.
*/

if ( $params['PROPERTY'] == "byManually" && $params['NEW_VALUE']){
	$this->setProperty('bySunTime', '0');
	$this->setProperty('bySensor', '0');
}elseif ( $params['PROPERTY'] == "bySunTime" && $params['NEW_VALUE']){
	$this->setProperty('byManually', '0');
	$this->setProperty('bySensor', '0');
}elseif ( $params['PROPERTY'] == "bySensor" && $params['NEW_VALUE']){
	$this->setProperty('bySunTime', '0');
	$this->setProperty('byManually', '0');
}elseif (!$this->getProperty('bySunTime') && !$this->getProperty('byManually') && !$this->getProperty('bySensor')){
	$this->setProperty('byManually', '1');
	$this->setProperty('bySunTime', '0');
	$this->setProperty('bySensor', '0');
}